<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Role;
use App\Models\Chauffeur;
use App\Models\Vehicule;
use App\Models\Document;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DriverOnboardingController extends Controller
{
    public function step1()
    {
        return view('driver.onboarding.step1');
    }

    public function storeStep1(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'numero_permis' => 'nullable|string|max:50',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
        ]);

        // Stocker les données en session
        Session::put('onboarding.step1', $request->all());

        return redirect()->route('driver.onboarding.step2');
    }

    public function step2()
    {
        // Vérifier que l'étape 1 est complétée
        if (!Session::has('onboarding.step1')) {
            return redirect()->route('driver.onboarding.step1');
        }

        return view('driver.onboarding.step2');
    }

    public function storeStep2(Request $request)
    {
        $request->validate([
            'type_vehicule' => 'required|string|in:camion,fourgonnette,voiture',
            'capacite_charge_kg' => 'required|numeric|min:0',
            'capacite_volume_m3' => 'nullable|numeric|min:0',
            'immatriculation' => 'required|string|unique:vehicules,immatriculation',
            'permis_conduire' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'carte_grise' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'assurance' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'type_vehicule.required' => 'Le type de véhicule est obligatoire.',
            'capacite_charge_kg.required' => 'La capacité de charge est obligatoire.',
            'immatriculation.required' => 'L\'immatriculation est obligatoire.',
            'immatriculation.unique' => 'Cette immatriculation est déjà enregistrée.',
            'permis_conduire.required' => 'Le permis de conduire est obligatoire.',
            'carte_grise.required' => 'La carte grise est obligatoire.',
            'assurance.required' => 'L\'assurance est obligatoire.',
            'permis_conduire.mimes' => 'Le permis doit être un fichier JPG, PNG ou PDF.',
            'carte_grise.mimes' => 'La carte grise doit être un fichier JPG, PNG ou PDF.',
            'assurance.mimes' => 'L\'assurance doit être un fichier JPG, PNG ou PDF.',
            '*.max' => 'Le fichier ne doit pas dépasser 2MB.',
        ]);

        // Stocker les fichiers temporairement
        $files = [];
        foreach (['permis_conduire', 'carte_grise', 'assurance'] as $doc) {
            if ($request->hasFile($doc)) {
                $files[$doc] = $request->file($doc)->store('temp', 'public');
            }
        }

        // Stocker les données en session
        $step2Data = $request->except(['permis_conduire', 'carte_grise', 'assurance']);
        $step2Data['files'] = $files;
        Session::put('onboarding.step2', $step2Data);

        return redirect()->route('driver.onboarding.step3');
    }

    public function step3()
    {
        // Vérifier que les étapes précédentes sont complétées
        if (!Session::has('onboarding.step1') || !Session::has('onboarding.step2')) {
            return redirect()->route('driver.onboarding.step1');
        }

        return view('driver.onboarding.step3');
    }

    public function complete(Request $request)
    {
        // var_dump(Session::get('onboarding.step2'),Session::get('onboarding.step1'));
        // exit;
        DB::beginTransaction();

        try {
            $step1 = Session::get('onboarding.step1');
            $step2 = Session::get('onboarding.step2');

            // 1. Récupérer le rôle chauffeur
            $role = Role::where('type', 'chauffeur')->firstOrFail();

            // 2. Création de l'utilisateur
            $user = User::create([
                'nom' => $step1['nom'],
                'prenom' => $step1['prenom'],
                'email' => $step1['email'],
                'phone' => $step1['phone'],
                'password' => Hash::make($step1['password']),
                'role_id' => $role->id,
                'est_actif' => false, // En attente de vérification
                'est_verifie' => false,
            ]);

            // 3. Création du chauffeur
            $chauffeur = $user->chauffeur()->create([
                'status' => 'en repos',
                'note_moyenne' => 0,
                'total_livraisons' => 0,
            ]);

            // 4. Création du véhicule
            $vehicule = $chauffeur->vehicule()->create([
                'type' => $step2['type_vehicule'],
                'immatriculation' => $step2['immatriculation'],
                'capacite_charge_kg' => $step2['capacite_charge_kg'],
                'capacite_volume_m3' => $step2['capacite_volume_m3'] ?? 0,
            ]);

            // 5. Déplacer les fichiers et créer les documents
            foreach ($step2['files'] as $type => $tempPath) {
                $finalPath = str_replace('temp/', 'documents/', $tempPath);
                Storage::disk('public')->move($tempPath, $finalPath);

                $chauffeur->documents()->create([
                    'type' => $type,
                    'chemin' => $finalPath,
                    'status' => 'en_attente',
                ]);
            }

            // 6. Nettoyer la session
            Session::forget(['onboarding.step1', 'onboarding.step2']);

            DB::commit();

            // Connecter l'utilisateur
            Auth::login($user);

            return redirect()->route('driver.onboarding.pending');

        } catch (\Exception $e) {
            DB::rollBack();

            // Nettoyer les fichiers temporaires
            if (isset($step2['files'])) {
                foreach ($step2['files'] as $tempPath) {
                    Storage::disk('public')->delete($tempPath);
                }
            }

            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création de votre compte.']);
        }
    }

    public function pending()
    {
        return view('driver.onboarding.pending');
    }
}

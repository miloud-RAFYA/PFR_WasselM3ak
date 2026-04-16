<?php

namespace App\Http\Controllers;

use App\Http\Requests\Driver\OnboardingStep1Request;
use App\Http\Requests\Driver\OnboardingStep2Request;
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

    public function storeStep1(OnboardingStep1Request $request)
    {
        Session::put('onboarding.step1', $request->validated());

        return redirect()->route('driver.onboarding.step2');
    }

    public function step2()
    {
        if (!Session::has('onboarding.step1')) {
            return redirect()->route('driver.onboarding.step1');
        }

        return view('driver.onboarding.step2');
    }

    public function storeStep2(OnboardingStep2Request $request)
    {
        $files = [];
        foreach (['permis_conduire', 'carte_grise', 'assurance'] as $doc) {
            if ($request->hasFile($doc)) {
                $files[$doc] = $request->file($doc)->store('temp', 'public');
            }
        }

        $step2Data = $request->except(['permis_conduire', 'carte_grise', 'assurance']);
        $step2Data['files'] = $files;
        Session::put('onboarding.step2', $step2Data);

        return redirect()->route('driver.onboarding.step3');
    }

    public function step3()
    {
        if (!Session::has('onboarding.step1') || !Session::has('onboarding.step2')) {
            return redirect()->route('driver.onboarding.step1');
        }

        return view('driver.onboarding.step3');
    }

    public function complete()
    {
        if (!Session::has('onboarding.step1') || !Session::has('onboarding.step2')) {
            return redirect()->route('driver.onboarding.step1');
        }
        $step1 = Session::get('onboarding.step1');
        $step2 = Session::get('onboarding.step2');

        if (!is_array($step1) || !is_array($step2)) {
            return redirect()->route('driver.onboarding.step1');
        }
        DB::beginTransaction();
        try {
            $role = Role::where('type', 'chauffeur')->firstOrFail();

            $user = User::create([
                'nom' => $step1['nom'],
                'prenom' => $step1['prenom'],
                'email' => $step1['email'],
                'phone' => $step1['phone'],
                'password' => Hash::make($step1['password']),
                'role_id' => $role->id,
                'est_actif' => false,
                'est_verifie' => false,
            ]);

            $chauffeur = $user->chauffeur()->create([
                'status' => 'en repos',
                'note_moyenne' => 0,
                'total_livraisons' => 0,
            ]);

            $chauffeur->vehicule()->create([
                'type' => $step2['type_vehicule'],
                'immatriculation' => $step2['immatriculation'],
                'capacite_charge_kg' => $step2['capacite_charge_kg'],
                'capacite_volume_m3' => $step2['capacite_volume_m3'] ?? 0,
            ]);

            if (!empty($step2['files']) && is_array($step2['files'])) {
                foreach ($step2['files'] as $type => $tempPath) {
                    if (!$tempPath || !Storage::disk('public')->exists($tempPath)) {
                        continue;
                    }

                    $finalPath = str_replace('temp/', 'documents/', $tempPath);
                    Storage::disk('public')->move($tempPath, $finalPath);

                    $chauffeur->documents()->create([
                        'type' => $type,
                        'chemin' => $finalPath,
                        'status' => 'en_attente',
                    ]);
                }
            }

            Session::forget(['onboarding.step1', 'onboarding.step2']);
            DB::commit();

            Auth::login($user);

            return redirect()->route('driver.onboarding.pending');
        } catch (\Exception $e) {
            DB::rollBack();

            if (!empty($step2['files']) && is_array($step2['files'])) {
                foreach ($step2['files'] as $tempPath) {
                    if ($tempPath && Storage::disk('public')->exists($tempPath)) {
                        Storage::disk('public')->delete($tempPath);
                    }
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

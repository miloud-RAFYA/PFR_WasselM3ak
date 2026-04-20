<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthController extends Controller
{
    public function signup()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::where('type', $request->user_type)->firstOrFail();
            $path = $request->hasFile('photo_profil') ? $request->file('photo_profil')->store('profiles', 'public') : null;

            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'photo' => $path,
                'role_id' => $role->id,
                'est_actif' => true,
                'est_verifie' => false,
            ]);
            //  var_dump($user);
            if ($request->user_type === 'chauffeur') {
                $chauffeur = $user->chauffeur()->create([
                    'status' => 'disponible',
                    'note_moyenne' => 0,
                    'total_livraisons' => 0,
                ]);
                //  var_dump($chauffeur);
                $vehicule = $chauffeur->vehicule()->create([
                    'type' => $request->type_vehicule,
                    'immatriculation' => $request->immatriculation,
                    'capacite_charge_kg' => $request->capacite_charge_kg,
                    'capacite_volume_m3' => $request->capacite_volume_m3 ?? 0,
                ]);
                //   var_dump($vehicule);
                foreach (['permis_conduire', 'carte_grise', 'assurance'] as $doc) {
                    if ($request->hasFile($doc)) {
                        $docPath = $request->file($doc)->store('documents', 'public');
                        //  var_dump($docPath);
                        $doc = $chauffeur->documents()->create([
                            'type' => $doc,
                            'chemin' => $docPath,
                            'status' => 'en_attente',
                        ]);
                    }
                }

                $redirectRoute = 'driver.dashboard';
            } elseif ($request->user_type === 'expediteur') {
                $user->expediteur()->create([
                    'adresse_principale' => $request->adresse_principale,
                    'total_envois' => 0,
                ]);

                $redirectRoute = 'client.dashboard';
            } else {
                throw new \Exception("Type d'utilisateur non reconnu.");
            }

            DB::commit();
            Auth::login($user);

            return redirect()->route($redirectRoute);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors de l'inscription : " . $e->getMessage());

            return back()->withInput()->withErrors([
                'error' => 'Une erreur est survenue lors de la création de votre compte.'
            ]);
        }
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return match ($user->role->type) {
                'expediteur' => redirect()->route('client.dashboard'),
                'chauffeur'  => redirect()->route('driver.dashboard'),
                'admin'      => redirect()->route('admin.dashboard'),
                default      => redirect('/'),
            };
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

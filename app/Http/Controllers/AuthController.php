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

class AuthController extends Controller
{
    public function signup()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        

       
            // 1. Récupérer le rôle
            $role = Role::where('type', $request->user_type)->firstOrFail();

            // 2. Upload photo de profil
            
            $path = $request->hasFile('photo_profil') ? $request->file('photo_profil')->store('profiles', 'public') : null;

            // 3. Création de l'utilisateur
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
             var_dump($user);
            exit;
            // 4. Logique spécifique selon le type d'utilisateur
            

            
            Auth::login($user);

            return redirect()->route('');

        
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
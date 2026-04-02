<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChauffeurController;
use App\Http\Controllers\DriverOnboardingController;
use App\Http\Controllers\ExpediteurController;
use App\Http\Controllers\ExpediteurDashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Role;
use App\Models\User;



Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    
    });
    Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/driver/dashboard', [ChauffeurController::class, 'dashboard'])->name('driver.dashboard');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/client/dashboard', [ExpediteurController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/driver/available',[ChauffeurController::class,'index'])->name('driver.available');
    Route::get('/driver/onboarding/pending', [DriverOnboardingController::class, 'pending'])->name('driver.onboarding.pending');
});




// Route::post('/register',[AuthController::class,'register']);
// Route::middleware('guest')->group(function () {
//     Route::view('/login', 'auth.login')->name('login');

//     Route::post('/login', function () {
        
//             return view('client/requests/dashboard');
//     });

//     Route::view('/register', 'auth.register')->name('register');

//     Route::post('/register', function (Request $request) {
//         $data = $request->validate([
//             'nom' => ['required', 'string', 'max:255'],
//             'prenom' => ['required', 'string', 'max:255'],
//             'email' => ['required', 'email', 'max:255', 'unique:users,email'],
//             'phone' => ['required', 'string', 'max:50'],
//             'password' => ['required', 'confirmed', 'min:8'],
//             'user_type' => ['required', 'in:client,driver,admin'],
//         ]);

//         $roleType = match ($data['user_type']) {
//             'client' => 'expediteur',
//             'driver' => 'chouffeur',
//             'admin' => 'admin',
//         };

//         $role = Role::firstOrCreate(['type' => $roleType]);

//         $user = User::create([
//             'nom' => $data['nom'],
//             'prenom' => $data['prenom'],
//             'email' => $data['email'],
//             'phone' => $data['phone'],
//             'password' => $data['password'],
//             'photo' => '',
//             'est_ectif' => true,
//             'est_verifie' => true,
//             'role_id' => $role->id,
//         ]);

//         Auth::login($user);

//         return redirect()->route('dashboard');
//     });
// });

// Route::post('/logout', function (Request $request) {
//     Auth::logout();

//     $request->session()->invalidate();
//     $request->session()->regenerateToken();

//     return redirect()->route('home');
// })->middleware('auth')->name('logout');

// // Dashboard redirection based on role
// Route::get('/dashboard', function () {
//     if (! Auth::check()) {
//         return redirect()->route('login');
//     }

//     $user = Auth::user();

  

//     return view('home');
// })->middleware('auth')->name('dashboard');

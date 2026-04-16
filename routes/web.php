<?php

use App\Events\UserTyping;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChauffeurController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\DriverOnboardingController;
use App\Http\Controllers\ExpediteurController;
use App\Http\Controllers\ExpediteurDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\TypingController;
use App\Http\Controllers\MessageController;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Role;
use App\Models\User;



Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::middleware('guest')->group(function () {});
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::get('/showLogin', [AuthController::class, 'showLogin'])->name('showLogin');
Route::get('/nexStep', [AuthController::class, 'nexStep'])->name('nexStep');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// web.php
// Ajouter cette route dans le groupe middleware auth
// Route pour le typing indicator (à placer avant les routes avec paramètres)
Route::middleware(['auth'])->group(function () {
    Route::post('/conversations/{conversation}/typing', [TypingController::class, 'typing'])->name('conversation.typing');
    Route::get('/conversations/{conversation}/messages', [MessageController::class, 'getMessages'])->name('conversation.messages');
    Route::get('/client/dashboard', [ExpediteurController::class, 'dashboard'])->name('client.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/driver/dashboard', [ChauffeurController::class, 'dashboard'])->name('driver.dashboard');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/driver/available', [ChauffeurController::class, 'index'])->name('driver.available');
    Route::get('/driver/offres/{demande}', [ChauffeurController::class, 'created'])->name('driver.offres.create');
    Route::post('/driver/offres/{demande}', [OffreController::class, 'store'])->name('driver.offres.store');
    Route::post('offres/{offre}', [OffreController::class, 'accepte'])->name('offre.accepte');
    // Route::get('/driver/onboarding/pending', [DriverOnboardingController::class, 'pending'])->name('driver.onboarding.pending');

    Route::post('/driver/toggle-availability', [ChauffeurController::class, 'toggleAvailability'])
        ->name('driver.toggle');

    Route::prefix('driver')->name('driver.')->group(function () {
        Route::get('/messages', [ChauffeurController::class, 'messages'])->name('messages');
        Route::get('/messages/{conversation}', [ChauffeurController::class, 'showConversation'])->name('messages.show');
        Route::post('/messages/{conversation}', [ChauffeurController::class, 'sendMessage'])->name('messages.send');
        Route::get('/tracking/{demande}', [TrackingController::class, 'driverTracking'])->name('tracking');
        Route::get('/trips', [ChauffeurController::class, 'trips'])->name('trips');
        Route::get('/vehicle', [ChauffeurController::class, 'vehicle'])->name('vehicle');
        Route::put('/vehicle', [ChauffeurController::class, 'updateVehicle'])->name('vehicle.update');
    });

    // Tracking client (GET positions)
    Route::get('/tracking/{demande}', [TrackingController::class, 'getPositions'])
        ->name('tracking.positions');

    // API envoi position
    Route::post('/api/send-position', [TrackingController::class, 'store'])
        ->name('tracking.send_position');

    // Routes Client - Demandes
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('/index', [DemandeController::class, 'index'])->name('index');
        Route::get('/requests/en-cours', [ExpediteurController::class, 'requestsInProgress'])->name('requests.in_progress');
        Route::get('/requests/suivi-gps', [ExpediteurController::class, 'requestsSuiviGps'])->name('requests.suivi_gps');
        Route::get('/requests/terminees', [ExpediteurController::class, 'requestsDelivered'])->name('requests.delivered');
        Route::get('/create', [DemandeController::class, 'create'])->name('create');
        Route::post('/requests', [DemandeController::class, 'store'])->name('requests.store');
        Route::get('/requests/{demande}', [ExpediteurController::class, 'showDemande'])->name('requests.show');
        Route::get('/messages', [ExpediteurController::class, 'messages'])->name('messages');
        Route::get('/messages/{conversation}', [ExpediteurController::class, 'showConversation'])->name('messages.show');
        Route::post('/messages/{conversation}', [ExpediteurController::class, 'sendMessage'])->name('messages.send');
    });

    // Route Profil
    Route::get('/profile', [ExpediteurController::class, 'profile'])->name('profile');
    Route::patch('/profile', [ExpediteurController::class, 'updateProfile'])->name('profile.update');

    // Routes resources Demande (API style)
    Route::resource('demandes', DemandeController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
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

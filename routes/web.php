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
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/conversations/{conversation}/typing', [TypingController::class, 'typing'])->name('conversation.typing');
    Route::get('/conversations/{conversation}/messages', [MessageController::class, 'getMessages'])->name('conversation.messages');

    // Route::get('/driver/onboarding/pending', [DriverOnboardingController::class, 'pending'])->name('driver.onboarding.pending');
    // Tracking client (GET positions)
    Route::get('/tracking/{demande}', [TrackingController::class, 'getPositions'])
        ->name('tracking.positions');
    Route::post('/api/send-position', [TrackingController::class, 'store'])
        ->name('tracking.send_position');
    Route::get('/tracking/{demande}', [TrackingController::class, 'driverTracking'])
        ->name('tracking');


    Route::get('/driver/dashboard', [ChauffeurController::class, 'dashboard'])->name('driver.dashboard');
    Route::post('/toggle-availability', [ChauffeurController::class, 'toggleAvailability'])
        ->name('driver.toggle');
    Route::get('/available', [ChauffeurController::class, 'index'])->name('driver.available');
    Route::get('/driver/trips', [ChauffeurController::class, 'trips'])->name('driver.trips');
    Route::post('/offres/{offre}', [OffreController::class, 'create'])->name('driver.offres.create');
    Route::prefix('driver')->name('driver.')->group(function () {
        Route::get('/vehicle', [ChauffeurController::class, 'vehicle'])->name('vehicle');
        Route::put('/vehicle', [ChauffeurController::class, 'updateVehicle'])->name('vehicle.update');
        Route::get('/messages', [ChauffeurController::class, 'messages'])->name('messages');
        Route::get('/messages/{conversation}', [ChauffeurController::class, 'showConversation'])->name('messages.show');
        Route::post('/messages/{conversation}', [ChauffeurController::class, 'sendMessage'])->name('messages.send');

        Route::post('/offres/{demande}', [OffreController::class, 'store'])->name('driver.offres.store');
        Route::post('/offres/{offre}', [OffreController::class, 'accepte'])->name('offre.accepte');
    });
    Route::get('/dashboard', [ExpediteurController::class, 'dashboard'])->name('client.dashboard');
    Route::prefix('client')->name('client.')->group(function () {

        Route::get('/requests/suivi-gps', [ExpediteurController::class, 'requestsSuiviGps'])->name('requests.suivi_gps');
        Route::get('/messages', [ExpediteurController::class, 'messages'])->name('messages');
        Route::get('/messages/{conversation}', [ExpediteurController::class, 'showConversation'])->name('messages.show');
        Route::post('/messages/{conversation}', [ExpediteurController::class, 'sendMessage'])->name('messages.send');

        //demandes
        Route::get('/index', [DemandeController::class, 'index'])->name('index');
        Route::get('/create', [DemandeController::class, 'create'])->name('create');
        Route::post('/requests', [DemandeController::class, 'store'])->name('requests.store');
        Route::get('/requests/{demande}', [DemandeController::class, 'show'])->name('requests.show');
        Route::put('/requests/{demande}', [DemandeController::class, 'update'])->name('requests.update');
        Route::delete('/requests/{demande}', [DemandeController::class, 'destroy'])->name('requests.destroy');
    });


    // Routes Client - Demandes

    // Route Profil
    Route::get('/profile', [ExpediteurController::class, 'profile'])->name('profile');
    Route::patch('/profile', [ExpediteurController::class, 'updateProfile'])->name('profile.update');

    // Routes resources Demande (API style)
    Route::resource('demandes', DemandeController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
});

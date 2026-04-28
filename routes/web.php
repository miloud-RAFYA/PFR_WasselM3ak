<?php

use App\Events\UserTyping;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChauffeurController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ExpediteurController;
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
    Route::get('/admin/user', [AdminDashboardController::class, 'users'])->name('admin.users');
    Route::patch('/admin/{users}/verify', [AdminDashboardController::class, 'verify'])->name('admin.users.verify');
    Route::patch('/admin/{users}/make-admin', [AdminDashboardController::class, 'makeAdmin'])->name('admin.users.make-admin');
    Route::get('/admin/{users}/documents', [AdminDashboardController::class, 'userDocuments'])->name('admin.users.documents');
    Route::patch('/admin/{users}/documents/verify-all', [AdminDashboardController::class, 'verifyAllUserDocuments'])->name('admin.users.documents.verify-all');
    Route::delete('/admin/{users}/destroy', [AdminDashboardController::class, 'destroy'])->name('admin.users.destroy');
    Route::patch('/admin/chauffeurs/{chauffeur}/comment', [AdminDashboardController::class, 'addComment'])->name('admin.users.comment');
    Route::get('/admin/statistics', [AdminDashboardController::class, 'statistics'])->name('admin.statistics');
    Route::get('/admin/demandes', [AdminDashboardController::class, 'demandes'])->name('admin.demandes');
    Route::patch('/admin/documents/{document}/verify', [AdminDashboardController::class, 'verifyDocument'])->name('admin.documents.verify');
    Route::delete('/admin/documents/{document}/destroy', [AdminDashboardController::class, 'destroyDocument'])->name('admin.documents.destroy');
    Route::post('/admin/documents/{document}/message', [AdminDashboardController::class, 'sendDocumentMessage'])->name('admin.documents.message');

    // gestion profil
    Route::get('/profile', [ExpediteurController::class, 'profile'])->name('profile');
    Route::patch('/profile', [ExpediteurController::class, 'updateProfile'])->name('profile.update');

    // Tracking routes
    // Tracking client (GET positions)
    Route::get('/tracking/{demande}/positions', [TrackingController::class, 'getPositions'])
        ->name('tracking.positions');
    Route::post('/tracking/update', [TrackingController::class, 'store'])->name('tracking.update');
    Route::post('/conversations/{conversation}/typing', [TypingController::class, 'typing'])->name('conversation.typing');
    Route::delete('/messages/{conversation}', [MessageController::class, 'destroy'])->name('client.messages.destroy');
    Route::get('/conversations/{conversation}/messages', [MessageController::class, 'getMessages'])->name('conversation.messages');


    Route::middleware(['role:chauffeur'])->group(function () {
        //  pages sidbar
        Route::get('/driver/dashboard', [ChauffeurController::class, 'dashboard'])->name('driver.dashboard');
        Route::post('/toggle-availability', [ChauffeurController::class, 'toggleAvailability'])
            ->name('driver.toggle');
        Route::get('/available', [ChauffeurController::class, 'index'])->name('driver.available');
        Route::get('/driver/trips', [ChauffeurController::class, 'trips'])->name('driver.trips');
        // pages create Offre
        Route::get('/offres/{demades}/create', [OffreController::class, 'createOffre'])->name('driver.offres.create');
        Route::put('/offres/{offres}/edit', [OffreController::class, 'edit'])->name('driver.offres.edit');
        Route::get('/offres/{offres}/update', [OffreController::class, 'update'])->name('driver.offres.update');
        Route::post('/driver/offres/{demandes}', [OffreController::class, 'store'])
            ->name('driver.offres.store');
        // chat put
        Route::get('/driver/messages', [ChauffeurController::class, 'messages'])->name('driver.messages');
        Route::get('/driver/messages/{conversation}', [ChauffeurController::class, 'showConversation'])->name('driver.messages.show');
        Route::post('/driver/messages/{conversation}', [ChauffeurController::class, 'sendMessage'])->name('driver.messages.send');
        // pages getion de vehicule
        Route::get('/driver/vehicle', [ChauffeurController::class, 'vehicle'])->name('driver.vehicle');
        Route::put('/driver/vehicle', [ChauffeurController::class, 'updateVehicle'])->name('driver.vehicle.update');
    });





    Route::middleware(['role:expediteur'])->group(function () {

        Route::get('/dashboard', [ExpediteurController::class, 'dashboard'])->name('client.dashboard');
        Route::get('/client/requests/suivi-gps', [ExpediteurController::class, 'requestsSuiviGps'])->name('client.requests.suivi_gps');
        Route::get('/client/messages', [ExpediteurController::class, 'messages'])->name('client.messages');
        Route::get('/client/messages/{conversation}', [ExpediteurController::class, 'showConversation'])->name('client.messages.show');
        Route::post('/client/messages/{conversation}', [ExpediteurController::class, 'sendMessage'])->name('client.messages.send');

        Route::post('/client/offres/{offres}/accepte', [OffreController::class, 'accepte'])->name('client.offre.accepte');
        Route::post('/client/offres/{offres}/refuse', [OffreController::class, 'refuse'])->name('client.offre.refuse');
        //demandes
        Route::get('/index', [DemandeController::class, 'index'])->name('client.index');
        Route::get('/create', [DemandeController::class, 'create'])->name('client.create');
        Route::post('/requests', [DemandeController::class, 'store'])->name('client.requests.store');
        Route::get('/requests/{demande}', [DemandeController::class, 'show'])->name('client.requests.show');
        Route::put('/requests/{demande}', [DemandeController::class, 'update'])->name('client.requests.update');
        Route::delete('/requests/{demande}', [DemandeController::class, 'destroy'])->name('client.requests.destroy');
    });
});

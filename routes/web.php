<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\FactureController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ReparationController;
use App\Http\Controllers\Admin\VehiculeController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\DashboardController;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Reparation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ── Page d'accueil publique ──
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ── Portail Client (Auth) ──
Route::name('client.')->prefix('client')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Routes protégées client
    Route::middleware('client.auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/vehicules', [DashboardController::class, 'vehicules'])->name('vehicules');
        Route::get('/vehicules/{id}', [DashboardController::class, 'vehiculeDetail'])->name('vehicules.detail');
        Route::get('/reparations', [DashboardController::class, 'reparations'])->name('reparations');
        Route::get('/messages', [DashboardController::class, 'messages'])->name('messages');
        Route::post('/messages', [DashboardController::class, 'sendMessage'])->name('messages.send');
    });
});

// ── Administration ──
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth Admin
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {
        // Dashboard
        Route::get('/', function () {
            $totalReparations = Reparation::count();
            $enCours = Reparation::where('statut', 'en cours')->count();
            $terminees = Reparation::where('statut', 'terminee')->count();
            $revenusMois = Facture::whereMonth('date_facture', now()->month)
                ->whereYear('date_facture', now()->year)
                ->sum('montant_total');
            $dernierClients = Client::orderBy('created_at', 'desc')->limit(5)->get();
            $dernieresReparations = Reparation::with('vehicule.client')->orderBy('created_at', 'desc')->limit(5)->get();

            return view('admin.dashboard', compact(
                'totalReparations', 'enCours', 'terminees', 'revenusMois', 'dernierClients', 'dernieresReparations'
            ));
        })->name('dashboard');

        // Ressources CRUD
        Route::resource('clients', ClientController::class);
        Route::resource('vehicules', VehiculeController::class);
        Route::resource('reparations', ReparationController::class)->except(['create']);
        Route::resource('factures', FactureController::class)->except(['create', 'edit']);
        Route::resource('messages', MessageController::class)->except(['create', 'store', 'edit', 'update']);

        // Routes supplémentaires
        Route::get('clients/{client_id}/vehicules/create', [VehiculeController::class, 'createForClient'])->name('vehicules.createForClient');
        Route::get('vehicules/{vehicule_id}/reparations/create', [ReparationController::class, 'create'])->name('reparations.create');
        Route::get('reparations/{reparation_id}/factures/create', [FactureController::class, 'create'])->name('factures.create');
        Route::get('factures/{id}/pdf', [FactureController::class, 'pdf'])->name('factures.pdf');
        Route::post('messages/{id}/repondre', [MessageController::class, 'repondre'])->name('messages.repondre');
    });
});

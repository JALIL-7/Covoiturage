<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/trajets', [TrajetController::class , 'index'])->name('trajets.index');
Route::get('/trajets/{trajet}', [TrajetController::class , 'show'])->whereNumber('trajet')->name('trajets.show');


Route::middleware(['auth', 'active'])->group(function () {

    // Dashboard (entry point) : show conducteur dashboard or passager home depending on role
    Route::get('/dashboard', function () {
            $user = auth()->user();
            if ($user && $user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if ($user && $user->role === 'conducteur') {
                return view('dashboard');
            }

            // For passengers, show a dedicated home page
            return view('passager.home');
        }
        )->name('dashboard');

        Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
            Route::get('/', [AdminController::class , 'dashboard'])->name('dashboard');

            Route::get('/users', [AdminController::class , 'users'])->name('users');
            Route::post('/users/{user}/role', [AdminController::class , 'updateUserRole'])->name('users.role');
            Route::post('/users/{user}/status', [AdminController::class , 'updateUserStatus'])->name('users.status');

            Route::get('/trajets', [AdminController::class , 'trajets'])->name('trajets');
            Route::delete('/trajets/{trajet}', [AdminController::class , 'deleteTrajet'])->name('trajets.destroy');

            Route::get('/reservations', [AdminController::class , 'reservations'])->name('reservations');
            Route::delete('/reservations/{reservation}', [AdminController::class , 'deleteReservation'])->name('reservations.destroy');

            Route::get('/vehicules', [AdminController::class , 'vehicules'])->name('vehicules');
            Route::delete('/vehicules/{vehicule}', [AdminController::class , 'deleteVehicule'])->name('vehicules.destroy');

            Route::get('/evaluations', [AdminController::class , 'evaluations'])->name('evaluations');
            Route::delete('/evaluations/{evaluation}', [AdminController::class , 'deleteEvaluation'])->name('evaluations.destroy');
        }
        );

        // Profile routes (edit/update/destroy)
        Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class , 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');
        Route::middleware(['auth', 'role:conducteur'])->group(function () {


            Route::get('/trajets/create', [TrajetController::class , 'create'])->name('trajets.create');
            Route::post('/trajets', [TrajetController::class , 'store'])->name('trajets.store');

            Route::get('/trajets/{trajet}/edit', [TrajetController::class , 'edit'])->name('trajets.edit');
            Route::put('/trajets/{trajet}', [TrajetController::class , 'update'])->name('trajets.update');
            Route::delete('/trajets/{trajet}', [TrajetController::class , 'destroy'])->name('trajets.destroy');

            Route::post('/vehicules', [VehiculeController::class , 'store'])->name('vehicules.store');
            Route::get('/vehicules', [VehiculeController::class , 'index'])
                ->name('vehicules.index');
            Route::get('/vehicules/create', [VehiculeController::class , 'create'])->name('vehicules.create');
            Route::get('/vehicules/{vehicule}', [VehiculeController::class , 'show'])->name('vehicules.show');
            Route::put('/vehicules/{vehicule}', [VehiculeController::class , 'update'])->name('vehicules.update');
            Route::get('/vehicules/{vehicule}/edit', [VehiculeController::class , 'edit'])
                ->name('vehicules.edit');

            Route::delete('/vehicules/{vehicule}', [VehiculeController::class , 'delete'])->name('vehicules.destroy');

            Route::post('/reservations', [ReservationController::class , 'store'])->name('reservations.store');
            Route::delete('/reservations/{reservation}', [ReservationController::class , 'destroy']);
            Route::post('/evaluations', [EvaluationController::class , 'store']);
            Route::get('/evaluations/index/{trajet}', [EvaluationController::class , 'index'])->name('evaluations.index');

            // Conductor view: all reservations
            Route::get('/conducteur/reservations', [ReservationController::class , 'reservationsForConducteur'])->name('reservations.conducteur');
            // Conductor view: reservations for a specific trajet
            Route::get('/conducteur/reservations/trajet/{trajet}', [ReservationController::class , 'reservationsForTrajet'])->name('reservations.conducteur.trajet');

            // Conductor view: evaluations with date filter
            Route::get('/conducteur/evaluations', [EvaluationController::class , 'evaluationsForConducteur'])->name('evaluations.conducteur');

        }
        );        Route::middleware(['auth', 'role:passager'])->group(function () {

            Route::get('/reservations', [ReservationController::class , 'myReservations'])->name('reservations.index');
            Route::get('/reservations/create', [ReservationController::class , 'create'])->name('reservations.create');
            Route::post('/reservations', [ReservationController::class , 'store'])->name('reservations.store_passager');
            Route::post('/reservations/evaluer', [ReservationController::class , 'storeAndEvaluate'])->name('reservations.store_and_evaluate');
            Route::delete('/reservations/{reservation}', [ReservationController::class , 'destroy']);
            Route::post('/evaluations', [EvaluationController::class , 'store']);

        });
    });

require __DIR__ . '/auth.php';
// Dans routes/web.php
use Illuminate\Support\Facades\URL;

if (env('APP_ENV') !== 'local' || strpos(env('APP_URL'), 'ngrok') !== false) {
    URL::forceScheme('https');
}

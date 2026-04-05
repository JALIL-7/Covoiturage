<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\EvaluationController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/trajets', [TrajetController::class , 'index'])->name('trajets.index');
Route::get('/trajets/{trajet}', [TrajetController::class , 'show'])->whereNumber('trajet')->name('trajets.show');


Route::middleware('auth')->group(function () {

    // Dashboard (entry point) : show conducteur dashboard or passager home depending on role
    Route::get('/dashboard', function () {
            $user = auth()->user();
            if ($user && $user->role === 'conducteur') {
                return view('dashboard');
            }

            // For passengers, show a dedicated home page
            return view('passager.home');
        }
        )->name('dashboard');

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

            Route::post('/vehicules', [VehiculeController::class , 'store']);
            Route::get('/vehicules', [VehiculeController::class , 'index'])
                ->name('vehicules.index');
            Route::get('/vehicules/create', [VehiculeController::class , 'create'])->name('vehicules.create');
            Route::get('/vehicules/{vehicule}', [VehiculeController::class , 'show'])->name('vehicules.show');
            Route::put('/vehicules/{vehicule}', [VehiculeController::class , 'update'])->name('vehicules.update');
            Route::get('/vehicules/{vehicule}/edit', [VehiculeController::class , 'edit'])
                ->name('vehicules.edit');

            Route::delete('/vehicules/{vehicule}', [VehiculeController::class , 'delete'])->name('vehicules.destroy');

            Route::post('/reservations', [ReservationController::class , 'store']);
            Route::delete('/reservations/{reservation}', [ReservationController::class , 'destroy']);
            Route::post('/evaluations', [EvaluationController::class , 'store']);
            Route::get('/evaluations/index/{trajet}', [EvaluationController::class , 'index'])->name('evaluations.index');

            // Conductor view: list reservations made on this conducteur's trajets
            Route::get('/conducteur/reservations', [ReservationController::class , 'reservationsForConducteur'])->name('reservations.conducteur');

            // Conductor view: list evaluations for my trajets
            Route::get('/conducteur/evaluations', [\App\Http\Controllers\EvaluationController::class , 'evaluationsForConducteur'])->name('evaluations.conducteur');

        }
        );        Route::middleware(['auth', 'role:passager'])->group(function () {

            Route::get('/reservations', [ReservationController::class , 'myReservations'])->name('reservations.index');
            Route::get('/reservations/create', [ReservationController::class , 'create'])->name('reservations.create');
            Route::post('/reservations', [ReservationController::class , 'store']);
            // Combined reservation + evaluation for passengers
            Route::post('/reservations/evaluer', [ReservationController::class , 'storeAndEvaluate'])->name('reservations.store_and_evaluate');
            Route::get('/evaluations/create/{trajet}', [EvaluationController::class , 'create'])->name('evaluations.create');
            Route::delete('/reservations/{reservation}', [ReservationController::class , 'destroy']);
            Route::post('/evaluations', [EvaluationController::class , 'store']);

        
}
        );    });

require __DIR__ . '/auth.php';

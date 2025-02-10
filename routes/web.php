<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

// Route group applying 'auth' middleware to all routes
Route::middleware(['auth', 'web', 'throttle:60,1'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/rstbl', [App\Http\Controllers\RstblController::class, 'index'])->name('resource_speaker.index');
    Route::get('/resource_speaker/create', [App\Http\Controllers\RstblController::class, 'create'])->name('resource_speaker.create');
    Route::post('resource_speaker', [App\Http\Controllers\RstblController::class, 'store'])->name('resource_speaker.store');
    Route::get('resource_speaker/{id}', [App\Http\Controllers\RstblController::class, 'show'])->name('resource_speaker.show');
    Route::get('resource_speaker/{id}/edit', [App\Http\Controllers\RstblController::class, 'edit'])->name('resource_speaker.edit');
    Route::put('resource_speaker/{id}', [App\Http\Controllers\RstblController::class, 'update'])->name('resource_speaker.update');
    Route::delete('resource_speaker/{id}', [App\Http\Controllers\RstblController::class, 'destroy'])->name('resource_speaker.destroy');

// User routes
Route::get('user', [App\Http\Controllers\UserController::class, 'index'])->name('accounts.index');
Route::get('users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('users/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
Route::get('users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::put('users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

    // Division routes
Route::get('/divisions', [App\Http\Controllers\DivisionController::class, 'index'])->name('divisions.index');
Route::get('divisions/create', [App\Http\Controllers\DivisionController::class, 'create'])->name('divisions.create');
Route::post('divisions', [App\Http\Controllers\DivisionController::class, 'store'])->name('divisions.store');
Route::get('divisions/{division}', [App\Http\Controllers\DivisionController::class, 'show'])->name('divisions.show');
Route::get('divisions/{division}/edit', [App\Http\Controllers\DivisionController::class, 'edit'])->name('divisions.edit');
Route::put('divisions/{division}', [App\Http\Controllers\DivisionController::class, 'update'])->name('divisions.update');
Route::delete('divisions/{division}', [App\Http\Controllers\DivisionController::class, 'destroy'])->name('divisions.destroy');


// Position routes
Route::get('positions', [App\Http\Controllers\PositionController::class, 'index'])->name('positions.index');
Route::get('positions/create', [App\Http\Controllers\PositionController::class, 'create'])->name('positions.create');
Route::post('positions', [App\Http\Controllers\PositionController::class, 'store'])->name('positions.store');
Route::get('positions/{position}', [App\Http\Controllers\PositionController::class, 'show'])->name('positions.show');
Route::get('positions/{position}/edit', [App\Http\Controllers\PositionController::class, 'edit'])->name('positions.edit');
Route::put('positions/{position}', [App\Http\Controllers\PositionController::class, 'update'])->name('positions.update');
Route::delete('positions/{position}', [App\Http\Controllers\PositionController::class, 'destroy'])->name('positions.destroy');


// Province routes
Route::get('provinces', [App\Http\Controllers\ProvinceController::class, 'index'])->name('provinces.index');
Route::get('provinces/create', [App\Http\Controllers\ProvinceController::class, 'create'])->name('provinces.create');
Route::post('provinces', [App\Http\Controllers\ProvinceController::class, 'store'])->name('provinces.store');
Route::get('provinces/{province}', [App\Http\Controllers\ProvinceController::class, 'show'])->name('provinces.show');
Route::get('provinces/{province}/edit', [App\Http\Controllers\ProvinceController::class, 'edit'])->name('provinces.edit');
Route::put('provinces/{province}', [App\Http\Controllers\ProvinceController::class, 'update'])->name('provinces.update');
Route::delete('provinces/{province}', [App\Http\Controllers\ProvinceController::class, 'destroy'])->name('provinces.destroy');


// Unit routes
Route::get('units', [App\Http\Controllers\UnitController::class, 'index'])->name('units.index');
Route::get('units/create', [App\Http\Controllers\UnitController::class, 'create'])->name('units.create');
Route::post('units', [App\Http\Controllers\UnitController::class, 'store'])->name('units.store');
Route::get('units/{unit}', [App\Http\Controllers\UnitController::class, 'show'])->name('units.show');
Route::get('units/{unit}/edit', [App\Http\Controllers\UnitController::class, 'edit'])->name('units.edit');
Route::put('units/{unit}', [App\Http\Controllers\UnitController::class, 'update'])->name('units.update');
Route::delete('units/{unit}', [App\Http\Controllers\UnitController::class, 'destroy'])->name('units.destroy');

});








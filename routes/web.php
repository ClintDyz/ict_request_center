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
    Route::get('/resource_speaker/create', [App\Http\Controllers\RstblController::class, 'create'])->name('resource_speaker.create'); // Show form
    Route::post('/resource_speaker', [App\Http\Controllers\RstblController::class, 'store'])->name('resource_speaker.store'); // Handle form submission
    Route::get('resource_speaker/{id}', [App\Http\Controllers\RstblController::class, 'show'])->name('resource_speaker.view');
    Route::get('resource_speaker/{id}/edit', [App\Http\Controllers\RstblController::class, 'edit'])->name('resource_speaker.edit');
    Route::put('resource_speaker/{id}', [App\Http\Controllers\RstblController::class, 'update'])->name('resource_speaker.update');
    Route::delete('resource_speaker/{id}', [App\Http\Controllers\RstblController::class, 'destroy'])->name('resource_speaker.destroy');

Route::get('/resource_speaker/pdf/{id}', [App\Http\Controllers\RstblController::class, 'printPDF'])->name('resource_speaker.print');


// User routes
Route::get('user', [App\Http\Controllers\UserController::class, 'index'])->name('accounts.index');
Route::get('users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('users/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
Route::get('users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::put('users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

//Tranings
Route::get('training', [App\Http\Controllers\RequestResourceSpeakerController::class, 'index'])->name('training.index');
Route::get('training/create', [App\Http\Controllers\RequestResourceSpeakerController::class, 'create'])->name('training.create');
Route::post('/training', [App\Http\Controllers\RequestResourceSpeakerController::class, 'store'])->name('training.store');
Route::delete('/training{id}', [App\Http\Controllers\RequestResourceSpeakerController::class, 'destroy'])->name('training.destroy');

// Show edit form (for the modal, we're using AJAX to fetch data)
Route::get('/request-resource-speaker/{id}/edit', [App\Http\Controllers\RequestResourceSpeakerController::class, 'edit'])->name('request_resource_speaker.edit');
Route::put('/request-resource-speaker/{id}', [App\Http\Controllers\RequestResourceSpeakerController::class, 'update'])->name('request_resource_speaker.update');
Route::post('/accreditations', [App\Http\Controllers\RequestResourceSpeakerController::class, 'add'])->name('request_resource_speaker.add');

// Route::get('/resource-speaker/{id}/form-preview',[App\Http\Controllers\RstblController::class, 'formPreview'])->name('resource_speaker.form_preview');

// Update the training record
// Route::put('trainings/{id}', [App\Http\Controllers\RequestResourceSpeakerController::class, 'update'])->name('trainings.update');

//AccreditationContller
Route::get('accreditation', [App\Http\Controllers\AccreditationController::class, 'index'])->name('accreditation.index');
Route::get('accreditation/viewaccredited', [App\Http\Controllers\AccreditationController::class, 'showAccredited'])->name('accreditation.viewaccredited');
// Route::get('/accreditation-form', [RequestResourceSpeakerController::class, 'showAccreditationForm'])->name('accreditation.form');
Route::post('accreditation/create', [App\Http\Controllers\AccreditationController::class, 'create'])->name('accreditation.create');
Route::get('/accreditation/{id}/edit', [App\Http\Controllers\AccreditationController::class, 'edit'])->name('accreditation.edit');
Route::put('/accreditation/{id}', [App\Http\Controllers\AccreditationController::class, 'update'])->name('accreditation.update');
Route::delete('/accreditation/{id}', [App\Http\Controllers\AccreditationController::class, 'destroy'])->name('accreditation.destroy');
Route::post('/accreditation/approve', [App\Http\Controllers\AccreditationController::class, 'approve'])->name('accreditation.approve');


// Route::get('/accreditation/pdf/{trainer}', [App\Http\Controllers\AccreditationController::class, 'generatePDF'])->name('accreditation.print');
// For AccreditationController
Route::get('/accreditation/pdf/{id}', [App\Http\Controllers\AccreditationController::class, 'printPDF'])
    ->name('accreditation.print');

// For AccreditationAverageController
Route::get('/accreditation/average/pdf/{id}', [App\Http\Controllers\AccreditationAverageController::class, 'generate'])
    ->name('accreditation.average.print');


//Average
Route::get('/accreditation_average', [App\Http\Controllers\AccreditationAverageController::class, 'index'])->name('accreditation.index');


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








<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisionUnitController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\IctEquipmentController;
use App\Http\Controllers\IDRequestController;
use App\Http\Controllers\DostCalendarController;
use App\Http\Controllers\ZoomRequestController;
use App\Http\Controllers\VehicleReservationController;
use App\Http\Controllers\BorrowerRequestController;
use App\Http\Controllers\ZoomRequestReportController;
use App\Http\Controllers\IDRequestReportController;


/*
|--------------------------------------------------------------------------
| LOGIN ROUTES
|--------------------------------------------------------------------------
*/

// Guest routes (Login)
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {



    // User management
    Route::resource('users', UserController::class);
        // Profile Routes
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('users.updateProfile');
    Route::put('/profile/change-password', [UserController::class, 'changePassword'])->name('users.changePassword');
    Route::put('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | PROTECTED MODULE ROUTES
    |--------------------------------------------------------------------------
    */
    Route::get('/welcome', [DivisionUnitController::class, 'show'])->name('welcome');

    Route::get('/units', [DivisionUnitController::class, 'index'])->name('division_unit.index');
    Route::post('/units', [DivisionUnitController::class, 'store'])->name('units.store');
    Route::put('/units/{id}', [DivisionUnitController::class, 'update'])->name('units.update');
    Route::delete('/units/{id}', [DivisionUnitController::class, 'destroy'])->name('units.destroy');

    Route::get('/positions', [PositionController::class, 'index'])->name('position.index');
    Route::post('/positions', [PositionController::class, 'store'])->name('position.store');
    Route::put('/positions/{id}', [PositionController::class, 'update'])->name('position.update');
    Route::delete('/positions/{id}', [PositionController::class, 'destroy'])->name('position.destroy');

    Route::get('/ict_equipment', [IctEquipmentController::class, 'index'])->name('ict_equipment.index');
    Route::post('/ict_equipment', [IctEquipmentController::class, 'store'])->name('ict_equipment.store');
    Route::put('/ict_equipment/{id}', [IctEquipmentController::class, 'update'])->name('ict_equipment.update');
    Route::delete('/ict_equipment/{id}', [IctEquipmentController::class, 'destroy'])->name('ict_equipment.destroy');

    Route::get('/zoom_request', [ZoomRequestController::class, 'index'])->name('zoom_request.index');
    Route::post('/zoom_request', [ZoomRequestController::class, 'store'])->name('zoom_request.store');
    Route::put('/zoom_request/{zoomRequest}', [ZoomRequestController::class, 'update'])->name('zoom_request.update');
    Route::delete('/zoom_request/{zoomRequest}', [ZoomRequestController::class, 'destroy'])->name('zoom_request.destroy');
    Route::put('zoom-request/{zoomRequest}/status', [ZoomRequestController::class, 'updateStatus'])->name('zoom_request.updateStatus');
     // Approved and Declined Routes
    Route::get('/approved', [ZoomRequestController::class, 'approved'])->name('zoom_request.approved');
    Route::get('/declined', [ZoomRequestController::class, 'declined'])->name('zoom_request.declined');

    // Zoom Report
    Route::get('/zoom_report', [ZoomRequestReportController::class, 'index'])->name('report.zoom_report');
    // ID Report
    Route::get('/id_report', [IDRequestReportController::class, 'index'])->name('report.id_report');
    Route::get('/id_report/export', [IDRequestReportController::class, 'export'])->name('id_report.export');


    Route::get('/id_request', [IDRequestController::class, 'index'])->name('id_request.index');
    Route::post('/store', [IDRequestController::class, 'store'])->name('id_request.store');
    Route::put('/update/{id}', [IDRequestController::class, 'update'])->name('id_request.update');
    Route::delete('/destroy/{id}', [IDRequestController::class, 'destroy'])->name('id_request.destroy');

    Route::get('/dost_car_calendar', [DostCalendarController::class, 'index'])->name('dost_calendar.index');
    Route::post('/dost_car_calendar', [DostCalendarController::class, 'store'])->name('dost_calendar.store');
    Route::put('/dost_car_calendar/{id}', [DostCalendarController::class, 'update'])->name('dost_calendar.update');
    Route::delete('/dost_car_calendar/{id}', [DostCalendarController::class, 'destroy'])->name('dost_calendar.destroy');

    Route::get('/vehicle-reservations', [VehicleReservationController::class, 'index'])->name('vehicle_reservations.index');
    Route::post('/vehicle-reservations', [VehicleReservationController::class, 'store'])->name('vehicle_reservations.store');
    Route::put('/vehicle-reservations/{id}/update', [VehicleReservationController::class, 'update'])->name('vehicle_reservations.update');
    Route::delete('/vehicle-reservations/{id}', [VehicleReservationController::class, 'destroy'])->name('vehicle_reservations.destroy');
    Route::get('/vehicle-reservations/{id}/download', [VehicleReservationController::class, 'downloadAttachment'])->name('vehicle_reservations.download');

    Route::get('/borrower_request', [BorrowerRequestController::class, 'index'])->name('borrower_request.index');
    Route::post('/borrower_request', [BorrowerRequestController::class, 'store'])->name('borrower_request.store');
    Route::put('/borrower_request/{id}', [BorrowerRequestController::class, 'update'])->name('borrower_request.update');
    Route::delete('/borrower_request/{id}', [BorrowerRequestController::class, 'destroy'])->name('borrower_request.destroy');
    Route::post('/borrower-request/{id}/return-items', [BorrowerRequestController::class, 'returnItems'])->name('borrower_request.return_items');

});

/*
|--------------------------------------------------------------------------
| DEFAULT ROUTE → Redirect to login
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

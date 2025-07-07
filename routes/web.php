<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CustController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PayPalController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    //return view('auth/login');
    return redirect()->route('login');
});

//route untuk register and login
Route::controller(AuthController::class)->group(function(){
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware(['auth', 'user-access:user'])->group(function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'user-access:admin'])->group(function(){
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin/home');
});

//car controller
Route::controller(CarController::class)->group(function(){
    Route::get('/carss', 'index')->name('cars.index');
    Route::get('/cars/create', 'create')->name('cars.create');
    Route::post('/cars/store', 'store')->name('cars.store');
    Route::get('/cars/{car}', 'show')->name('cars.show');
    Route::get('/cars/edit/{car}', 'edit')->name('cars.edit');
    Route::put('/cars/{car}', 'update')->name('cars.update');
    Route::delete('/cars/{car}', 'destroy')->name('cars.destroy');
});

//customer-admin controller
Route::controller(CustController::class)->group(function(){
    Route::get('/customers', 'index')->name('customers.index');
    Route::get('/customers/show/{cust}', 'show')->name('customers.show');
    Route::delete('/customers/{cust}', 'destroy')->name('customers.destroy');
});

//bookings controller
Route::controller(BookingController::class)->group(function(){
    Route::get('/bookings', 'index')->name('bookings.index');
    Route::get('/bookings/cust/{books}', 'show')->name('bookings.show');
    Route::get('/bookings/{books}', 'status')->name('bookings.status');
    Route::delete('/bookings/{books}', 'destroy')->name('bookings.destroy');
});

//user punya route
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create/{car}', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/bookings/{booking}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/bookings/{booking}', [UserController::class, 'update'])->name('users.update');
//confirmation
Route::get('/users/confirm/{id}', [UserController::class, 'detail'])->name('users.confirmation');
Route::post('/users/confirmation', [UserController::class, 'confirmation'])->name('users.confirmationTotal');

Route::get('/users/{booking}/extend', [UserController::class, 'extendform'])->name('users.extendform');
Route::put('/users/extend/{booking}', [UserController::class, 'updateextendform'])->name('users.extendformupdate');
Route::delete('/users/{booking}', [BookingController::class, 'destroyUser'])->name('bookings.destroyUser');

//paypal controller
Route::post('/paypal', [PayPalController::class, 'paypal'])->name('paypal');
Route::get('success', [PayPalController::class, 'success'])->name('success');
Route::get('cancel', [PayPalController::class, 'cancel'])->name('cancel');
//kalo lepas bayau success
Route::get('receipt/{payment}', [PayPalController::class, 'receipt'])->name('users.receipt');



//admin tengok payment controller
Route::get('/payments', [PayPalController::class, 'index'])->name('payments.index');
Route::get('/payments/{payment}', [PayPalController::class, 'show'])->name('payments.show');


// Route for downloading receipt as PDF
Route::get('/receipt/pdf/{payment}', [PayPalController::class, 'generateReceipt'])->name('receipt.pdf');







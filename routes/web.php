<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\error\ErrorController;
use App\Http\Controllers\clients\HomeController;
use App\Http\Controllers\clients\OwnerController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/', [UserController::class, 'index']);

    Route::post('/login', [UserController::class, 'login'])->name('login');

    Route::get('/sign_up', [UserController::class, 'register'])->name('register');

    Route::post('/sign_up', [UserController::class, 'check_register'])->name('check_register');

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/user_actived/{user}/{token}', [UserController::class, 'actived'])->name('user.actived');

    //Forgot Password
    Route::get('/forgot_password', [UserController::class, 'forgotPassowrd'])->name('forgot_password');

    Route::post('/forgot_password', [UserController::class, 'postForgetPassword'])->name('forgot_passowrd_mail');

    Route::get('/get_forgot_password/{user}/{token}', [UserController::class, 'getForgotPasword'])->name('get_forgot_password');

    Route::post('/get_forgot_password/{user}/{token}', [UserController::class, 'postForgotPasword'])->name('post_forgot_password');


    // Owner login
    Route::get('/owner_login', [UserController::class, 'login_owner'])->name('login_owner');

    Route::post('/owner_login', [UserController::class, 'check_login_owner'])->name('check_login_owner');

    //Owner register
    Route::get('/owner_register', [UserController::class, 'register_owner'])->name('register_owner');

    Route::post('/owner_register', [UserController::class, 'check_register_owner'])->name('check_register_owner');

    Route::get('/owner_actived/{user}/{token}', [UserController::class, 'owner_actived'])->name('owner.actived');




});


//Route clients
Route::prefix('/user')->name('user.')->middleware('auth')->group(function () {

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // Route::post();
});

// Route owner

Route::get('/owner/login_error', [OwnerController::class, 'login_error'])->name('owner_login_error');


Route::prefix('/owner')->middleware('permission.checker:OWNER|')->name('owner.')->group(function () {

    Route::get('/', [OwnerController::class, 'index'])->name('index');

    Route::get('/profile', [OwnerController::class, 'profile'])->name('profile');

    Route::post('/profile', [OwnerController::class, 'edit_profile'])->name('edit_profile');

    Route::get('/vehicle', [OwnerController::class, 'vehicle'])->name('vehicle');

    Route::post('/vehicle', [OwnerController::class, 'store_vehicle'])->name('store_vehicle');

   Route::post('/logout', [OwnerController::class, 'logout'])->name('logout');

});


//Route errors

Route::get('error_403', [ErrorController::class, 'error_403'])->name('403');


//Test view
Route::get('test_view', [UserController::class, 'test_view'])->name('test_view');
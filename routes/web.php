<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/getAdjustedTotals/{timePeriod}', [App\Http\Controllers\HomeController::class, 'getAdjustedTotals']);
// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function(){
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);

// Permissions
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

// Users 
Route::middleware('auth')->prefix('users')->name('users.')->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');

    
    Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

    Route::get('export/', [UserController::class, 'export'])->name('export');
    Route::get('/activitylog/{user}', [UserController::class, 'activitylog'])->name('activitylog');

});

Route::middleware('auth')->prefix('customer')->name('customer.')->group(function(){
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/store', [CustomerController::class, 'store'])->name('store');
    Route::get('/edit/{user}', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/update/{user}', [CustomerController::class, 'update'])->name('update');
    Route::get('/delete/{user}', [CustomerController::class, 'delete'])->name('destroy');
    Route::post('/search', [CustomerController::class, 'search'])->name('search');    
    Route::get('/update/status/{user_id}/{status}', [CustomerControllerr::class, 'updateStatus'])->name('status');
    Route::get('/customertransaction/{user}', [CustomerController::class, 'customertransaction'])->name('customertransaction');
    Route::get('/deletecompany/{companyid}', [CustomerController::class, 'deletecompany'])->name('deletecompany');
    Route::get('/activitylog/{user}', [CustomerController::class, 'activitylog'])->name('activitylog');
});


Route::middleware('auth')->prefix('transaction')->name('transaction.')->group(function(){
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::get('/create', [TransactionController::class, 'create'])->name('create');
    Route::post('/store', [TransactionController::class, 'store'])->name('store');
    Route::get('/edit/{user}', [TransactionController::class, 'edit'])->name('edit');
    Route::put('/update/{user}', [TransactionController::class, 'update'])->name('update');
    Route::get('/delete/{user}', [TransactionController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [TransactionController::class, 'updateStatus'])->name('status');
    Route::post('/search', [TransactionController::class, 'search'])->name('search');
    Route::get('/activitylog/{user}', [TransactionController::class, 'activitylog'])->name('activitylog');
    Route::get('/customercompany', [TransactionController::class, 'customercompany'])->name('customercompany');
    Route::get('/searchcustomer', [TransactionController::class, 'searchcustomer'])->name('searchcustomer');
    Route::get('/searchcompany', [TransactionController::class, 'searchcompany'])->name('searchcompany');
});
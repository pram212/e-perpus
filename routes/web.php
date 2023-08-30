<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect('login');
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('users', UserController::class);
    
    Route::group(['prefix'=>'pustaka','as'=>'pustaka.'], function () {
        Route::resource('book', BookController::class);
        Route::resource('catalog', CatalogController::class);
    });

    Route::get('/getcatalog', [BookController::class, 'getCatalog']);
    Route::get('/getbook', [BookController::class, 'getBooks']);
    
    Route::group(['prefix'=>'setting','as'=>'setting.'], function () {
        Route::resource('company-profile', CompanyProfileController::class);
    });
    
    Route::group(['prefix'=>'transaction','as'=>'transaction.'], function () {
        Route::resource('loan', BookLoanController::class);
        Route::get('/getbookoptions', [BookLoanController::class, 'getBookOpitons']);
        Route::get('/getuseroptions', [BookLoanController::class, 'getUserOpitons']);
        Route::get('/getbookloan', [BookLoanController::class, 'getBookLoans']);
    });

    Route::resource('anggota', AnggotaController::class);
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\ScoreResultController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\AlternativeValueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

Route::group(['prefix' => 'alternative'], function () {
    Route::get('/', [AlternativeController::class, 'index'])->name('alternative.weboender.index')->middleware('auth');
    Route::get('/create', [AlternativeController::class, 'create'])->name('alternative.weboender.create')->middleware('auth');
    Route::post('/', [AlternativeController::class, 'store'])->name('alternative.weboender.store')->middleware('auth');
    Route::get('/{alternative}/edit', [AlternativeController::class, 'edit'])->name('alternative.edit');
    Route::put('/{alternative}', [AlternativeController::class, 'update'])->name('alternative.update');
    Route::delete('/{alternative}', [AlternativeController::class, 'destroy'])->name('alternative.destroy');
});

Route::group(['prefix' => 'criteria'], function () {
    Route::get('/', [CriteriaController::class, 'index'])->name('criteria.weboender.index')->middleware('auth');
    Route::get('/create/data', [CriteriaController::class, 'create'])->name('criteria.weboender.create')->middleware('auth');
    Route::post('/', [CriteriaController::class, 'store'])->name('criteria.weboender.store')->middleware('auth');
    Route::get('/{criteria}/edit', [CriteriaController::class, 'edit'])->name('criteria.edit');
    Route::put('/{criteria}', [CriteriaController::class, 'update'])->name('criteria.update');
    Route::delete('/criteria/{criteria}', [CriteriaController::class, 'destroy'])->name('criteria.destroy');
});

Route::group(['prefix' => 'community'], function () {
    Route::get('/', [CommunityController::class, 'index'])->name('community.index')->middleware('auth');
    Route::get('/create', [CommunityController::class, 'create'])->name('community.create')->middleware('auth');
    Route::post('/', [CommunityController::class, 'store'])->name('community.store')->middleware('auth');
    Route::get('/list', [CommunityController::class, 'getCommunity'])->name('community.list');
    Route::get('/{community}/edit', [CommunityController::class, 'edit'])->name('community.edit');
    Route::put('/{community}', [CommunityController::class, 'update'])->name('community.update');
    Route::delete('/{community}', [CommunityController::class, 'destroy'])->name('community.destroy');
});

Route::group(['prefix' => 'result'], function () {
    Route::get('/', [ScoreResultController::class, 'index'])->name('result.index')->middleware('auth'); // cek kembali name route
    Route::group(['prefix' => '{communityName}'], function () {
        Route::get('/', [ScoreResultController::class, 'show'])->name('result.show')->middleware('auth'); // cek kembali name route
    });

});

Route::group(['prefix' => 'scoring'], function () {
    Route::post('/alternative/get-by-community', [AlternativeController::class, 'getCommunityIdByAlternative'])->name('alternative.get-by-community');
    Route::get('/create', [AlternativeValueController::class, 'create'])->name('scoring.create')->middleware('auth');
    Route::post('/store', [AlternativeValueController::class, 'store'])->name('scoring.store')->middleware('auth');
    Route::post('/check-exist', [AlternativeValueController::class, 'checkExist'])->name('scoring.check-exist');

    Route::group(['prefix' => '{communityName}'], function () {
        Route::get('/', [AlternativeValueController::class, 'index'])->name('scoring.index')->middleware('auth'); // need penyesuaian
    });

});

// Route::get('/result/{communityName}', [ScoreResultController::class, 'index'])->name('result.index');

// dont forget to delete
Route::get('/utility', [ScoreResultController::class, 'calculateUtilityForAll']);
Route::get('/final', [ScoreResultController::class, 'calculateFinalUtilityForAll']);
Route::get('/masuk', [ScoreResultController::class, 'calculateRankingAndStore']);
Route::get('/bobot', [ScoreResultController::class, 'criteriaWeight']);
Route::get('/fraction', [ScoreResultController::class, 'fraction']);



// SPK
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/', function () {
    return redirect('/dashboard');
});

// tables -> Kriteria
Route::get('/tables', function () {
    return view('tables');
})->name('tables')->middleware('auth');

// RTL -> Alternatif

// alternatif weboender
// Route::get('/alternatif', function () {
//     return view('RTL');
// })->name('alternatif')->middleware('auth');

// Route::get('/', function () {
//     return redirect('/dashboard');
// })->middleware('auth');

Route::get('/wallet', function () {
    return view('wallet');
})->name('wallet')->middleware('auth');

Route::get('/profile', function () {
    return view('account-pages.profile');
})->name('profile')->middleware('auth');

Route::get('/signin', function () {
    return view('account-pages.signin');
})->name('signin');

Route::get('/signup', function () {
    return view('account-pages.signup');
})->name('signup')->middleware('guest');

Route::get('/sign-up', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('sign-up');

Route::post('/sign-up', [RegisterController::class, 'store'])
    ->middleware('guest');

Route::get('/sign-in', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('sign-in');

Route::post('/sign-in', [LoginController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'store'])
    ->middleware('guest');

Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('users.profile')->middleware('auth');
Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update')->middleware('auth');
Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management')->middleware('auth');

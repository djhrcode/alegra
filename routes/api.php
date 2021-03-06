<?php

use App\Contest\Application\Controllers\ContestActiveCreateController;
use App\Contest\Application\Controllers\ContestActiveShowController;
use App\Contest\Application\Controllers\ContestResetController;
use App\Contest\Application\Controllers\ContestResultsListController;
use App\Contest\Application\Controllers\ContestShowController;
use App\Seller\Application\Controllers\SellerImagesSearchController;
use App\Seller\Application\Controllers\SellerSearchController;
use App\Seller\Application\Controllers\SellerShowController;
use App\Seller\Application\Controllers\SellerUpvoteController;
use App\User\Application\Controllers\UserLoginController;
use App\User\Application\Controllers\UserRegisterController;
use App\User\Application\Controllers\UserShowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return response()->json([
        "message" => "Welcome to Vendedores A Correr API"
    ]);
});

Route::get('/sellers/images', SellerImagesSearchController::class)->name('sellers.images.search');

Route::get('/sellers', SellerSearchController::class)->name('sellers.search');
Route::get('/sellers/{seller}', SellerShowController::class)->name('sellers.show');
Route::post('/sellers/{seller}/upvote', SellerUpvoteController::class)->name('sellers.upvote');


Route::post('/contests/active/reset', ContestResetController::class)->name('contests.active.reset');
Route::get('/contests/active', ContestActiveShowController::class)->name('contests.active.show');
Route::post('/contests/active', ContestActiveCreateController::class)->name('contests.active.create');

Route::get('/contests/{contest}', ContestShowController::class)->name('contests.show');
Route::get('/contests/{contest}/results', ContestResultsListController::class)->name('contests.results.list');

Route::post('/auth/login', UserLoginController::class)->name('auth.login');
Route::post('/auth/register', UserRegisterController::class)->name('auth.register');

Route::get('/account', UserShowController::class)->name('account.show');

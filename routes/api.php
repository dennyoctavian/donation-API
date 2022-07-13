<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(UserController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(CampaignController::class)->group(function () {
    Route::get('list-campaign', 'index');
    Route::post('add-campaign', 'store');
    Route::get('detail-campaign/{id}', 'show');
    Route::put('update-campaign/{id}', 'update');
    Route::delete('delete-campaign/{id}', 'destroy');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('list-category', 'listAllCategory');
    Route::post('add-category', 'createCategory');
    Route::put('update-category/{id}', 'updateCategory');
    Route::delete('delete-category/{id}', 'deleteCategory');
    Route::post('accept-campaign/{id}', 'acceptCampaign');
    Route::post('reject-campaign/{id}', 'rejectCampaign');
});

Route::controller(TransactionController::class)->group(function () {
    Route::get('transaction', 'index');
    Route::post('transaction/{id}', 'store');
});

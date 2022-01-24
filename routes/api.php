<?php

use App\Http\Controllers\FrameController;
use App\Http\Controllers\GameController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'as' => 'api.',
], function() {
    Route::group([
        'as' => 'game.',
        'prefix' => 'game',
    ], function() {
        Route::get('/{game}', [GameController::class, 'get'])->name('get');
        Route::post('/', [GameController::class, 'create'])->name('create');

        Route::post('/{game}/frame/{frame}', [FrameController::class, 'setScore'])->name('frame.set-score');
    });
});


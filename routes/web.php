<?php

use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::group([
        'prefix' => 'admin',
        'middleware' => 'auth',
        'as' => 'admin.'
    ], function () {
        Route::resource('clients', AdminClientController::class);
        Route::resource('tasks', AdminTaskController::class);
        Route::resource('projects', AdminProjectController::class);
    });
});

require __DIR__ . '/auth.php';

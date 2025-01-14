<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index']);
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
});

// 削除（追加機能）
Route::delete('/{id}', [App\Http\Controllers\ItemController::class, 'delete'])->name('items.delete');

// 検索（追加機能）
Route::get('/', [App\Http\Controllers\ItemController::class, 'serch'])->name('items.index');

// 編集 (編集機能)
Route::get('/items/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('items.edit');
Route::post('/items/edit/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('items.update');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PartsController;

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
    if (empty(auth()->user())) {
        return redirect()->to('/auth/login');
    }
    else{
        return redirect()->to('/dashboard');
    }
});

Route::get('/auth/login',function (){
    return view('login');
})->name('login');
Route::any('/auth/logout',function (){
    \Illuminate\Support\Facades\Auth::logoutCurrentDevice();
    return response()->json('success');
})->name('logout');



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',function (){
        return view('dashboard');
    });
    Route::get('/categories',[CategoryController::class,'index']);
    Route::post('/insertCategory',[CategoryController::class,'createCategory']);
    Route::post('/updateCategory',[CategoryController::class,'updateItem']);
    Route::get('/deleteCategory/{id}',[CategoryController::class,'deleteCategory']);
    Route::get('/api/categoryList',[CategoryController::class,'getItemList']);

    Route::get('/parts/{type}/{is_shop}',[PartsController::class,'index']);
    Route::post('/insertParts',[PartsController::class,'createPart']);
    Route::post('/updateParts',[PartsController::class,'updatePart']);
    Route::get('/deleteParts/{id}',[PartsController::class,'deletePart']);
    Route::get('/api/partsList/{type}/{is_shop}',[PartsController::class,'getItemList']);
});


Route::get('/register',function (){
    return view('register');
});
Route::post('/auth/login',[LoginController::class,'login']);
Route::post('/auth/register',[LoginController::class,'register'])->name('register');

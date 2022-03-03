<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PartsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FileController;

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
    Route::any('/dashboard',[CustomerController::class,'index']);
    Route::any('/getCustomerInfo/{id}',[CustomerController::class,'getCustomerInfo']);
    Route::any('/api/dashboard',[CustomerController::class,'index']);
    Route::get('/categories',[CategoryController::class,'index']);
    Route::get('/userList',[UserController::class,'index']);
    Route::post('/insertUser',[UserController::class,'insertUser']);
    Route::post('/updateUser',[UserController::class,'updateUser']);
    Route::get('/deleteUser/{id}',[UserController::class,'deleteUser']);
    Route::get('/api/userList',[UserController::class,'getUserList']);
    Route::get('/getInvoiceList/{id}',[\App\Http\Controllers\InvoiceController::class,'getInvoiceList']);
    Route::post('/insertCategory',[CategoryController::class,'createCategory']);
    Route::post('/updateCategory',[CategoryController::class,'updateItem']);
    Route::get('/deleteCategory/{id}',[CategoryController::class,'deleteCategory']);
    Route::get('/api/categoryList',[CategoryController::class,'getItemList']);

    Route::get('/parts/{type}/{is_shop}',[PartsController::class,'index']);
    Route::post('/insertParts',[PartsController::class,'createPart']);
    Route::post('/updateParts',[PartsController::class,'updatePart']);
    Route::get('/deleteParts/{id}',[PartsController::class,'deletePart']);
    Route::any('/customer/attach_file',[FileController::class,'uploadCustomerAttach']);
    Route::get('/api/partsList/{type}/{is_shop}',[PartsController::class,'getItemList']);

    Route::post('/insertInvoice',[\App\Http\Controllers\InvoiceController::class,'insertInvoice']);
    Route::post('/insertCustomer',[\App\Http\Controllers\CustomerController::class,'insertCustomer']);
    Route::post('/updateCustomer/{id}',[\App\Http\Controllers\CustomerController::class,'updateCustomer']);
    Route::get('/deleteCustomer/{id}',[\App\Http\Controllers\CustomerController::class,'deleteCustomer']);
    Route::get('/deleteInvoice/{id}',[\App\Http\Controllers\InvoiceController::class,'deleteInvoice']);
    Route::get('/pdfInvoiceExport/{id}',[\App\Http\Controllers\InvoiceController::class,'pdfInvoiceExport']);
    Route::get('/export_customers',[\App\Http\Controllers\CustomerController::class,'exportCustomers']);
    Route::get('/export_categories',[\App\Http\Controllers\CategoryController::class,'exportCategories']);
    Route::get('/export_invoices',[\App\Http\Controllers\CustomerController::class,'exportInvoices']);
    Route::get('/export_parts',[\App\Http\Controllers\PartsController::class,'exportParts']);
    Route::post('/import_customers',[\App\Http\Controllers\CustomerController::class,'importCustomers']);
    Route::post('/import_invoices',[\App\Http\Controllers\CustomerController::class,'importInvoices']);
    Route::post('/import_categories',[\App\Http\Controllers\CategoryController::class,'importCategories']);
    Route::post('/import_parts',[\App\Http\Controllers\PartsController::class,'importParts']);

});


Route::get('/register',function (){
    return view('register');
});
Route::post('/auth/login',[LoginController::class,'login']);
Route::post('/auth/register',[LoginController::class,'register'])->name('register');
Route::any('/recoverPassword/{email}',[UserController::class,'recoverPassword']);

<?php

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
    Route::any('/dashboard','\App\Http\Controllers\CustomerController@index');
    Route::any('/getCustomerInfo/{id}','\App\Http\Controllers\CustomerController@getCustomerInfo');
    Route::any('/api/dashboard','\App\Http\Controllers\CustomerController@index');
    Route::get('/categories','\App\Http\Controllers\CategoryController@index');
    Route::get('/userList','\App\Http\Controllers\UserController@index');
    Route::post('/insertUser','\App\Http\Controllers\UserController@insertUser');
    Route::post('/updateUser','\App\Http\Controllers\UserController@updateUser');
    Route::get('/deleteUser/{id}','\App\Http\Controllers\UserController@deleteUser');
    Route::get('/api/userList','\App\Http\Controllers\UserController@getUserList');
    Route::get('/getInvoiceList/{id}','\App\Http\Controllers\InvoiceController@getInvoiceList');
    Route::post('/insertCategory','\App\Http\Controllers\CategoryController@createCategory');
    Route::post('/updateCategory','\App\Http\Controllers\CategoryController@updateItem');
    Route::get('/deleteCategory/{id}','\App\Http\Controllers\CategoryController@deleteCategory');
    Route::get('/api/categoryList','\App\Http\Controllers\CategoryController@getItemList');

    Route::get('/parts/{type}/{is_shop}','\App\Http\Controllers\PartsController@index');
    Route::post('/insertParts','\App\Http\Controllers\PartsController@createPart');
    Route::post('/updateParts','\App\Http\Controllers\PartsController@updatePart');
    Route::get('/deleteParts/{id}','\App\Http\Controllers\PartsController@deletePart');
    Route::any('/customer/attach_file','\App\Http\Controllers\FileController@uploadCustomerAttach');
    Route::get('/api/partsList/{type}/{is_shop}','\App\Http\Controllers\PartsController@getItemList');

    Route::post('/insertInvoice','\App\Http\Controllers\InvoiceController@insertInvoice');
    Route::post('/insertCustomer','\App\Http\Controllers\CustomerController@insertCustomer');
    Route::post('/updateCustomer/{id}','\App\Http\Controllers\CustomerController@updateCustomer');
    Route::get('/deleteCustomer/{id}','\App\Http\Controllers\CustomerController@deleteCustomer');
    Route::get('/deleteInvoice/{id}','\App\Http\Controllers\InvoiceController@deleteInvoice');
    Route::get('/pdfInvoiceExport/{id}','\App\Http\Controllers\InvoiceController@pdfInvoiceExport');
    Route::get('/export_customers','\App\Http\Controllers\CustomerController@exportCustomers');
    Route::get('/export_categories','\App\Http\Controllers\CategoryController@exportCategories');
    Route::get('/export_invoices','\App\Http\Controllers\CustomerController@exportInvoices');
    Route::get('/export_parts','\App\Http\Controllers\PartsController@exportParts');
    Route::post('/import_customers','\App\Http\Controllers\CustomerController@importCustomers');
    Route::post('/import_invoices','\App\Http\Controllers\CustomerController@importInvoices');
    Route::post('/import_categories','\App\Http\Controllers\CategoryController@importCategories');
    Route::post('/import_parts','\App\Http\Controllers\PartsController@importParts');

});


Route::get('/register',function (){
    return view('register');
});
Route::post('/auth/login','Auth\LoginController@login');
Route::post('/auth/register','\App\Http\Controllers\Auth\LoginController@register')->name('register');
Route::any('/recoverPassword/{email}','\App\Http\Controllers\UserController@recoverPassword');


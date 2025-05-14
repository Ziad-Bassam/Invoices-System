<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Models\Invoice_archive;
use App\Models\Invoices_details;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('invoices', InvoiceController::class);
Route::resource('sections', SectionController::class);
Route::resource('products', ProductController::class);
Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class);
Route::resource('archive', InvoiceArchiveController::class);




Route::get('/section/{id}', [InvoiceController::class, 'getproducts']);

Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class, 'show']);

Route::post('/delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

Route::get('/status_show/{id}', [InvoiceController::class, 'show'])->name('status_show');
Route::get('/invoices_paid', [InvoiceController::class, 'invoices_paid']);
Route::get('/print_invoice/{id}', [InvoiceController::class, 'print_invoice']);
Route::get('/invoices_unpaid', [InvoiceController::class, 'invoices_unpaid']);
Route::get('/invoices_partial', [InvoiceController::class, 'invoices_partial']);

Route::delete('invoice_archive/{id}', [InvoiceController::class, 'InvoiceArchive'])->name('InvoiceArchive');

Route::post('/status_update/{id}', [InvoiceController::class, 'status_update'])->name('status_update');

// !show file
// Route::get('/view_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);

Route::get('/edit_invoice/{id}', [InvoiceController::class, 'edit']);


// Route::group(['middleware' => ['auth']], function() {

//     Route::resource('roles','RoleController');
    
//     Route::resource('users','UserController');
// });


Route::group(['middleware' => 'auth'],function(){
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});

Route::get('invoices_report', [InvoicesReportController::class , 'index']);
Route::post('search_invoices', [InvoicesReportController::class , 'search_invoices']);


Route::get('customers_report', [CustomersReportController::class , 'index']);
Route::post('search_customers', [CustomersReportController::class , 'search_customers']);

Route::get('MarkAsRead_all',[InvoiceController::class , 'MarkAsRead_all'])->name('MarkAsRead_all');
Route::get('unreadNotifications_count', [InvoiceController::class , 'unreadNotifications_count'])->name('unreadNotifications_count');
Route::get('unreadNotifications', [InvoiceController::class , 'unreadNotifications'])->name('unreadNotifications');


Route::get('/{page}', [AdminController::class, 'index']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

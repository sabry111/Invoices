<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceReportController;
use App\Http\Controllers\InvoicesArchiveController;
use App\Http\Controllers\InvoicesAttachmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('invoices', InvoiceController::class);

    Route::get('/section/{id}', [InvoiceController::class, 'getproducts']);

    Route::get('/Invoice_Paid', [InvoiceController::class, 'Invoice_Paid'])->name('invoices.Invoice_Paid');

    Route::get('/Invoice_unPaid', [InvoiceController::class, 'Invoice_unPaid'])->name('invoices.Invoice_unPaid');

    Route::get('/Invoice_Partial', [InvoiceController::class, 'Invoice_Partial'])->name('invoices.Invoice_Partial');

    Route::get('/invoicesdetails/{id}', [InvoiceController::class, 'details'])->name('invoices.details');

    Route::get('/status_show/{id}', [InvoiceController::class, 'show'])->name('status_show');

    Route::post('/status_update/{id}', [InvoiceController::class, 'status_update'])->name('status_update');

    Route::get('Print_invoice/{id}', [InvoiceController::class, 'Print_invoice'])->name('invoices.Print_invoice');

    Route::resource('sections', SectionController::class);

    Route::resource('products', ProductController::class);

    Route::resource('attashments', InvoicesAttachmentController::class);

    Route::resource('archive', InvoicesArchiveController::class);

    Route::post('/restore/{id}', [InvoicesArchiveController::class, 'restore'])->name('archive.restore');

    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);

    Route::get('/view_file/{invoice_number}/{file_name}', [InvoicesAttachmentController::class, 'openfile']);

    Route::get('/download/{invoice_number}/{file_name}', [InvoicesAttachmentController::class, 'getfile']);

    Route::post('delete_file', [InvoicesAttachmentController::class, 'destroy'])->name('delete_file');

    Route::get('invoices_report', [InvoiceReportController::class, 'index']);

    Route::post('search_invoices', [InvoiceReportController::class, 'search_invoices']);

    Route::get('customers_report', [CustomerReportController::class, 'index']);

    Route::post('search_customers', [CustomerReportController::class, 'search_customers']);

    Route::get('/mark_all', [InvoiceController::class, 'mark_all']);

    // Route::get('/mark_one/{id}', [InvoiceController::class, 'mark_one'])->name('invoices.mark_one');

    Route::get('/{page}', [AdminController::class, 'index']);

});

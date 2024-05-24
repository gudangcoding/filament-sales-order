<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
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


// Route::prefix('admin/{tenant}/invoices')->group(function () {
//     Route::get('{id}/print', [InvoiceController::class, 'print'])->name('invoices.print');
// });
Route::prefix('admin/{tenant}/pdf')->group(function () {
    Route::get('{id}/invoice', [PdfController::class, 'invoice'])->name('pdf.invoice');
});
Route::get('/', function () {
    return view('welcome');
});

// Route::get('/invoice', [PdfController::class, 'invoice'])->name('invoice');



// // Route::resource('invoices', InvoiceController::class);
// Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
// Route::get('invoices/print', [InvoiceController::class, 'print'])->name('invoices.print');
// Route::get('invoices/cetak', [InvoiceController::class, 'cetak'])->name('invoices.cetak');
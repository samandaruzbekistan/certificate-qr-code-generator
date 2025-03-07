<?php

use App\Http\Controllers\AdminController;
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
Route::view('/', 'admin.login')->name('admin.login');
Route::prefix('admin')->group(function () {
    Route::post('/auth', [AdminController::class, 'auth'])->name('admin.auth');
    Route::middleware(['admin_auth'])->group(function () {
        Route::get('home', [AdminController::class, 'home'])->name('admin.home');
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::post('update', [AdminController::class, 'update'])->name('admin.update');

        Route::post('new-certificate', [AdminController::class, 'newCertificate'])->name('admin.newCertificate');
        Route::post('new-image', [AdminController::class, 'upload_image'])->name('admin.upload.image');
        Route::get('certificate/{id}', [AdminController::class, 'certificate'])->name('admin.certificate');
        Route::get('certificate-delete/{id}', [AdminController::class, 'deleteCertificate'])->name('admin.certificate.delete');
    });
});
Route::get('certificate/{id}', [AdminController::class, 'show_certificate'])->name('show');
Route::get('certificate-download/{id}', [AdminController::class, 'downloadCertificate'])->name('admin.certificate.download');


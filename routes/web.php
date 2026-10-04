<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\FormBuilderController;
use App\Http\Controllers\Admin\ResponseController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\InventoryFormController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User / Partner Inventory Form Routes (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', [InventoryFormController::class, 'showForm'])->name('form.index');
Route::get('/form', [InventoryFormController::class, 'showForm']);
Route::post('/form', [InventoryFormController::class, 'submitForm'])->name('form.submit');
Route::get('/form/success/{code}', [InventoryFormController::class, 'showSuccess'])->name('form.success');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Responses Management
    Route::get('/responses', [ResponseController::class, 'index'])->name('responses.index');
    Route::get('/responses/{response}', [ResponseController::class, 'show'])->name('responses.show');
    Route::get('/responses/{response}/pdf', [ResponseController::class, 'printPdf'])->name('responses.pdf');
    Route::delete('/responses/{response}', [ResponseController::class, 'destroy'])->name('responses.destroy');

    // Dynamic Form Builder ("Kelola Form")
    Route::get('/form-builder', [FormBuilderController::class, 'index'])->name('form-builder.index');
    Route::post('/form-builder/fields', [FormBuilderController::class, 'storeField'])->name('form-builder.field.store');
    Route::put('/form-builder/fields/{field}', [FormBuilderController::class, 'updateField'])->name('form-builder.field.update');
    Route::post('/form-builder/fields/{field}/toggle', [FormBuilderController::class, 'toggleField'])->name('form-builder.field.toggle');
    Route::delete('/form-builder/fields/{field}', [FormBuilderController::class, 'destroyField'])->name('form-builder.field.destroy');
    Route::post('/form-builder/settings', [FormBuilderController::class, 'updateSettings'])->name('form-builder.settings.update');

    // Exports
    Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/csv', [ExportController::class, 'exportCsv'])->name('export.csv');
});

/*
|--------------------------------------------------------------------------
| Database Migration Utility (Web Runner)
|--------------------------------------------------------------------------
*/
Route::get('/migrate-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        return response()->json([
            'status' => 'success',
            'message' => 'Migrasi database berhasil dijalankan!',
            'details' => $output
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menjalankan migrasi: ' . $e->getMessage()
        ], 500);
    }
});

Route::get('/seed-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        return response()->json([
            'status' => 'success',
            'message' => 'Database Seeding berhasil dijalankan!',
            'details' => $output
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menjalankan seeding: ' . $e->getMessage()
        ], 500);
    }
});

Route::get('/optimize-clear', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $output = \Illuminate\Support\Facades\Artisan::output();
        return response()->json([
            'status' => 'success',
            'message' => 'Cache & Optimize berhasil dibersihkan!',
            'details' => $output
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal clear cache: ' . $e->getMessage()
        ], 500);
    }
});

/*
|--------------------------------------------------------------------------
| Storage File Delivery & Symlink Fallback
|--------------------------------------------------------------------------
*/
Route::get('/storage/{path}', function ($path) {
    $cleanPath = ltrim($path, '/');
    $possibleLocations = [
        storage_path('app/public/' . $cleanPath),
        public_path('storage/' . $cleanPath),
        base_path('storage/app/public/' . $cleanPath),
    ];

    foreach ($possibleLocations as $file) {
        if (file_exists($file) && is_file($file)) {
            $mimeType = @mime_content_type($file) ?: 'application/octet-stream';
            return response()->file($file, [
                'Content-Type' => $mimeType,
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }
    }

    abort(404, 'File gambar tidak ditemukan.');
})->where('path', '.*')->name('storage.serve');

Route::get('/storage-link', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return response()->json([
            'status' => 'success',
            'message' => 'Storage link berhasil dibuat!',
            'details' => \Illuminate\Support\Facades\Artisan::output()
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

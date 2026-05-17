<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentCategoryController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDocumentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// ========================
// PUBLIC ROUTES
// ========================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========================
// USER AUTHENTICATED ROUTES
// ========================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kategori & Dokumen
    Route::get('/buat-dokumen', [DocumentCategoryController::class, 'index'])->name('documents.index');
    Route::get('/buat-dokumen/{slug}', [DocumentCategoryController::class, 'create'])->name('documents.create');
    Route::post('/buat-dokumen/{slug}', [DocumentCategoryController::class, 'store'])->name('documents.store');

    // Preview & Download
    Route::get('/dokumen/{document}/preview', [DocumentCategoryController::class, 'preview'])->name('documents.preview');
    Route::get('/dokumen/{document}/download', [DocumentCategoryController::class, 'download'])->name('documents.download');
    Route::put('/dokumen/{document}', [DocumentCategoryController::class, 'update'])->name('documents.update');
    Route::delete('/dokumen/{document}', [DocumentCategoryController::class, 'destroy'])->name('documents.destroy');

    // Live Preview API
    Route::post('/api/preview/{slug}', [DocumentCategoryController::class, 'livePreview'])->name('documents.live-preview');

    // Request kategori baru
    Route::get('/request-kategori', function () {
        return view('documents.request');
    })->name('documents.request');

    // Riwayat dokumen user
    Route::get('/riwayat', [DashboardController::class, 'history'])->name('documents.history');
});

// ========================
// ADMIN ROUTES
// ========================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminDocumentController::class, 'dashboard'])->name('dashboard');

    // Kategori management
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    Route::patch('/categories/{category}/toggle', [AdminCategoryController::class, 'toggle'])->name('categories.toggle');

    // Dokumen management
    Route::get('/documents', [AdminDocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{document}', [AdminDocumentController::class, 'show'])->name('documents.show');
    Route::delete('/documents/{document}', [AdminDocumentController::class, 'destroy'])->name('documents.destroy');

    // Users management
    Route::get('/users', [AdminDocumentController::class, 'users'])->name('users.index');

    // Reports
    Route::get('/reports', [AdminDocumentController::class, 'reports'])->name('reports.index');
    Route::get('/reports/export', [AdminDocumentController::class, 'exportReport'])->name('reports.export');
});

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController as AuthRegisterController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LegalCaseController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

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

Route::middleware('isGuest')->group(function () {
    // LOGIN SECTION
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('loginIndex');

    // REGISTER SECTION
    Route::get('/register', [AuthRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthRegisterController::class, 'register'])->name('submit.register');
    Route::get('/forgot-password', [ChangePasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ChangePasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ChangePasswordController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {

    Route::middleware(['isMaster'])->group(function () {
        // USER MANAGEMENT
        Route::get('/usermanagement', [UserController::class, 'userManagementIndex'])->name('User Management Page');
        Route::get('/usermanagement/profile/{id}', [UserController::class, 'show'])->name('master.user.profile');
        Route::get('/usermanagement/profile/{id}/edit', [UserController::class, 'edit'])->name('master.profile.edit');
        Route::patch('/usermanagement/profile/{id}/edit', [UserController::class, 'update'])->name('master.profile.update');
        Route::get('/usermanagement/search', [UserController::class, 'searchUsers'])->name('user.search');
    });

    Route::middleware(['isMasterOrAdmin'])->group(function () {
        // TEAM
        Route::get('/buat-tim', [TeamController::class, 'getUserNames'])->name('team.create');
        Route::post('/buat-tim', [TeamController::class, 'createTeam'])->name('team.store');
        Route::get('/tim/{team}', [TeamController::class, 'edit'])->name('team.edit');
        Route::patch('/tim/{team}', [TeamController::class, 'update'])->name('team.update');
        //KLIEN
        Route::get('/kasus/{id}/klien/{client_id}/edit', [ClientController::class, 'edit'])->name('client.edit');
        Route::patch('/klien/{client_id}', [ClientController::class, 'update'])->name('client.update');
        //LIST-PENDAFTAR
        Route::get('/list-pendaftar', [AdminController::class, 'index'])->name('admin.list-pendaftar');
        Route::post('/list-pendaftar/store/{id}', [AdminController::class, 'store'])->name('admin.store');
        //FILE
        Route::delete('/file/{file}', [FileController::class, 'destroy'])->name('file.destroy');


        // KASUS
        Route::post('/kasus/{legalCase}/tutup', [LegalCaseController::class, 'tutupKasus'])->name('kasus.tutup');
    });


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    //HOME SECTION
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //PROFILE SECTION
    Route::get('/profile/{id}', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');

    // KASUS
    Route::get('/kasus', [LegalCaseController::class, 'index'])->name('kasus.index');
    Route::get('/kasus/create', [LegalCaseController::class, 'create'])->name('kasus.create');
    Route::post('/kasus', [LegalCaseController::class, 'store'])->name('kasus.store');
    Route::get('/kasus/search', [LegalCaseController::class, 'searchLegalCases'])->name('kasus.search');
    Route::get('/kasus/{legalCase}', [LegalCaseController::class, 'show'])->name('kasus.show');
    Route::get('/kasus/{id}/edit-deskripsi-kasus', [LegalCaseController::class, 'editDeskripsiKasus'])->name('deskripsi_kasus.edit');
    Route::patch('kasus/{id}/edit-deskripsi-kasus', [LegalCaseController::class, 'updateDeskripsiKasus'])->name('deskripsi_kasus.update');

    //PROFIL CLIENT
    Route::get('/kasus/{id}/klien/{client_id}', [ClientController::class, 'index'])->name('client.index');

    // PASSWORD
    Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [ChangePasswordController::class, 'changePassword']);

    //TEAM SECTION
    Route::get('/tim', [TeamController::class, 'index'])->name('team.index');
    Route::get('/tim/search', [TeamController::class, 'searchTeam'])->name('team.search');

    //FILES
    Route::get('/unggah-dokumen', [FileController::class, 'index'])->name('file.unggah-dokumen');
    Route::post('/unggah-dokumen/upload', [FileController::class, 'store'])->name('file.upload');
    Route::get('/file/{id}/edit', [FileController::class, 'edit'])->name('file.edit');
    Route::patch('/file/{id}', [FileController::class, 'update'])->name('file.update');

    // COMMENT
    Route::post('/legal-cases/{id}/comments', [CommentController::class, 'store'])->name('comment.store');

    Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
});

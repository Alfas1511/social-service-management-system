<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PresidentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThriftLoanController;
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

Route::get('/', [LoginController::class, 'loginPage'])->name('login-page');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::prefix('president')->middleware(['role:ADS'])->group(function () {
        Route::get('/', [PresidentController::class, 'index'])->name('president.index');
        Route::get('/create', [PresidentController::class, 'create'])->name('president.create');
        Route::post('/store', [PresidentController::class, 'store'])->name('president.store');
        Route::get('/edit', [PresidentController::class, 'edit'])->name('president.edit');
        Route::post('/delete/{id}', [PresidentController::class, 'delete'])->name('president.delete');
    });

    Route::prefix('member')->middleware(['role:PRESIDENT'])->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('member.index');
        Route::get('/create', [MemberController::class, 'create'])->name('member.create');
        Route::post('/store', [MemberController::class, 'store'])->name('member.store');
        Route::get('/edit', [MemberController::class, 'edit'])->name('member.edit');
        Route::post('/delete/{id}', [MemberController::class, 'delete'])->name('member.delete');
    });

    Route::prefix('notebooks')->middleware(['role:PRESIDENT,MEMBER'])->group(function () {
        Route::get('/', [NotebookController::class, 'index'])->name('notebooks.index');
        Route::post('/store', [NotebookController::class, 'store'])->name('notebooks.store');
        Route::get('/getMemberNotebookTotal', [NotebookController::class, 'getMemberTotal'])->name('getMemberNotebookTotal');
        Route::get('/getMemberNotebookPayments', [NotebookController::class, 'getMemberNotebookPayments'])->name('getMemberNotebookPayments');
    });

    Route::prefix('thrift-loans')->middleware(['role:PRESIDENT,MEMBER'])->group(function () {
        Route::get('/', [ThriftLoanController::class, 'index'])->name('thrift-loans.index');
        Route::post('/store', [ThriftLoanController::class, 'store'])->name('thrift-loans.store');
        Route::get('/getMemberThriftLoanTotal', [ThriftLoanController::class, 'getMemberThriftLoanTotal'])->name('getMemberThriftLoanTotal');
        Route::get('/getMemberThriftLoanPayments', [ThriftLoanController::class, 'getMemberThriftLoanPayments'])->name('getMemberThriftLoanPayments');
    });

    Route::prefix('loans')->middleware(['role:PRESIDENT,MEMBER'])->group(function () {
        Route::get('/', [LoanController::class, 'index'])->name('loans.index');
        Route::post('/store', [LoanController::class, 'store'])->name('loans.store');
        Route::get('/getMemberLoanTotal', [LoanController::class, 'getMemberLoanTotal'])->name('getMemberLoanTotal');
        Route::get('/getMemberLoanPayments', [LoanController::class, 'getMemberLoanPayments'])->name('getMemberLoanPayments');
    });

    Route::prefix('attendance')->middleware(['role:PRESIDENT,MEMBER'])->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/store', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::post('/dates-store', [AttendanceController::class, 'dateStore'])->name('dates.store');
        Route::get('/getMemberAttendances', [AttendanceController::class, 'getMemberAttendances'])->name('getMemberAttendances');
        Route::post('/updateStatus', [AttendanceController::class, 'updateStatus'])->middleware(['role:MEMBER'])->name('attendance.updateStatus');
        Route::post('/attendanceFine', [AttendanceController::class, 'giveFine'])->middleware(['role:PRESIDENT'])->name('attendance.givefine');
    });

    Route::prefix('fines')->middleware(['role:MEMBER'])->group(function () {
        Route::get('/', [FineController::class, 'index'])->name('fines.index');
        Route::post('/updateStatus', [FineController::class, 'updateStatus'])->name('fines.payFine');
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->middleware(['role:PRESIDENT,ADS'])->name('notifications.index');
        Route::get('/create', [NotificationController::class, 'create'])->middleware(['role:ADS'])->name('notifications.create');
        Route::post('/store', [NotificationController::class, 'store'])->middleware(['role:ADS'])->name('notifications.store');
    });

    Route::prefix('coupons')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->middleware(['role:PRESIDENT,ADS'])->name('coupons.index');
        Route::get('/create', [CouponController::class, 'create'])->middleware(['role:ADS'])->name('coupons.create');
        Route::post('/store', [CouponController::class, 'store'])->middleware(['role:ADS'])->name('coupons.store');
    });
});

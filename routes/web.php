<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SchoolPackageController as AdminSchoolPackageController;
use App\Http\Controllers\Admin\SchoolSubmissionController as AdminSchoolSubmissionController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ETicketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolSubmissionController;
use App\Http\Controllers\TicketOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/tickets/{ticket}', [CatalogController::class, 'showTicket'])->name('catalog.ticket');
Route::get('/packages/{package}', [CatalogController::class, 'showPackage'])->name('catalog.package');

Route::post('/payments/notification', [PaymentController::class, 'notification'])->name('payments.notification');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('catalog.index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/tickets/{ticket}/order', [TicketOrderController::class, 'create'])->name('ticket-orders.create');
    Route::post('/ticket-orders', [TicketOrderController::class, 'store'])->name('ticket-orders.store');

    Route::get('/packages/{package}/submit', [SchoolSubmissionController::class, 'create'])->name('school-submissions.create');
    Route::post('/school-submissions', [SchoolSubmissionController::class, 'store'])->name('school-submissions.store');
    Route::get('/school-submissions/{submission}', [SchoolSubmissionController::class, 'show'])->name('school-submissions.show');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/payments/{order}/pay', [PaymentController::class, 'pay'])->name('payments.pay');
    Route::get('/payments/{order}/finish', [PaymentController::class, 'finish'])->name('payments.finish');

    Route::get('/etickets/{order}', [ETicketController::class, 'show'])->name('etickets.show');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('tickets', AdminTicketController::class);
        Route::resource('school-packages', AdminSchoolPackageController::class)->parameters([
            'school-packages' => 'school_package',
        ]);

        Route::get('/school-submissions', [AdminSchoolSubmissionController::class, 'index'])->name('school-submissions.index');
        Route::get('/school-submissions/{submission}', [AdminSchoolSubmissionController::class, 'show'])->name('school-submissions.show');
        Route::post('/school-submissions/{submission}/approve', [AdminSchoolSubmissionController::class, 'approve'])->name('school-submissions.approve');
        Route::post('/school-submissions/{submission}/reject', [AdminSchoolSubmissionController::class, 'reject'])->name('school-submissions.reject');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    });

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GymAdmin\AttendanceController as GymAdminAttendanceController;
use App\Http\Controllers\GymAdmin\BillingController as GymAdminBillingController;
use App\Http\Controllers\GymAdmin\DashboardController as GymAdminDashboardController;
use App\Http\Controllers\GymAdmin\EquipmentController as GymAdminEquipmentController;
// MainAdmin Controllers
use App\Http\Controllers\GymAdmin\ExpenseController as GymAdminExpenseController;
use App\Http\Controllers\GymAdmin\MemberController as GymAdminMemberController;
use App\Http\Controllers\GymAdmin\MembershipController as GymAdminMembershipController;
use App\Http\Controllers\GymAdmin\PaymentController as GymAdminPaymentController;
use App\Http\Controllers\GymAdmin\ProfileController as GymAdminProfileController;
use App\Http\Controllers\GymAdmin\SettingController as GymAdminSettingController;
// GymAdmin Controllers
use App\Http\Controllers\GymAdmin\SportController as GymAdminSportController;
use App\Http\Controllers\GymAdmin\StaffController as GymAdminStaffController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainAdmin\DashboardController as MainAdminDashboardController;
use App\Http\Controllers\MainAdmin\GymController as MainAdminGymController;
use App\Http\Controllers\MainAdmin\GymPlanController as MainAdminGymPlanController;
use App\Http\Controllers\MainAdmin\PlanController as MainAdminPlanController;
use App\Http\Controllers\MainAdmin\ProfileController as MainAdminProfileController;
use App\Http\Controllers\MainAdmin\UserController as MainAdminUserController;
use App\Http\Controllers\Staff\AttendanceController as StaffAttendanceController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\EquipmentController as StaffEquipmentController;
use App\Http\Controllers\Staff\MemberController as StaffMemberController;
// Staff Controllers
use App\Http\Controllers\Staff\PaymentController as StaffPaymentController;
use App\Http\Controllers\Staff\ProfileController as StaffProfileController;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\ThrottleFailedLogins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Auth::routes();
Route::get('/', [HomeController::class, 'index']);
Route::post('/contact', [HomeController::class, 'sendContactForm'])->name('contact.send');
Route::post('/login', [LoginController::class, 'login'])->middleware(ThrottleFailedLogins::class);

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::middleware(CheckUserStatus::class)->group(function () {

        // MainAdmin Routes with Prefix 'main_admin'
        Route::prefix('main_admin')->middleware(['auth', 'role:main_admin'])->name('main_admin.')->group(function () {
            Route::get('dashboard', [MainAdminDashboardController::class, 'index'])->name('dashboard');

            // Users Routes
            Route::controller(MainAdminUserController::class)->prefix('users')->group(function () {
                Route::get('', 'index')->name('users.index');
                Route::get('show/{id}', 'show')->name('users.show');
                Route::get('create', 'create')->name('users.create');
                Route::post('store', 'store')->name('users.store');
                Route::get('edit/{id}', 'edit')->name('users.edit');
                Route::put('edit/{id}', 'update')->name('users.update');
                Route::delete('destroy/{id}', 'destroy')->name('users.destroy');
            });

            // Gyms Routes
            Route::controller(MainAdminGymController::class)->prefix('gyms')->group(function () {
                Route::get('', 'index')->name('gyms.index');
                Route::get('show/{id}', 'show')->name('gyms.show');
                Route::get('create', 'create')->name('gyms.create');
                Route::post('store', 'store')->name('gyms.store');
                Route::get('edit/{id}', 'edit')->name('gyms.edit');
                Route::put('edit/{id}', 'update')->name('gyms.update');
                Route::delete('destroy/{id}', 'destroy')->name('gyms.destroy');
            });

            // Plans Routes
            Route::controller(MainAdminPlanController::class)->prefix('plans')->group(function () {
                Route::get('', 'index')->name('plans.index');
                Route::get('show/{id}', 'show')->name('plans.show');
                Route::get('create', 'create')->name('plans.create');
                Route::post('store', 'store')->name('plans.store');
                Route::get('edit/{id}', 'edit')->name('plans.edit');
                Route::put('edit/{id}', 'update')->name('plans.update');
                Route::delete('destroy/{id}', 'destroy')->name('plans.destroy');
            });

            // Gym Plans Routes
            Route::controller(MainAdminGymPlanController::class)->prefix('gym-plans')->group(function () {
                Route::get('', 'index')->name('gym-plans.index');
                Route::get('show/{id}', 'show')->name('gym-plans.show');
                Route::get('create', 'create')->name('gym-plans.create');
                Route::post('store', 'store')->name('gym-plans.store');
                Route::get('edit/{id}', 'edit')->name('gym-plans.edit');
                Route::put('edit/{id}', 'update')->name('gym-plans.update');
                Route::delete('destroy/{id}', 'destroy')->name('gym-plans.destroy');
            });

            // Profile Routes
            Route::get('/profile', [MainAdminProfileController::class, 'index'])->name('profile');
            Route::post('/profile', [MainAdminProfileController::class, 'update'])->name('profile.update');
            Route::post('/profile/deactivate', [MainAdminProfileController::class, 'deactivate'])->name('profile.deactivate');

            // Security Routes
            Route::get('/security', [MainAdminProfileController::class, 'security'])->name('security');
            Route::post('/security/password', [MainAdminProfileController::class, 'updatePassword'])->name('security.updatePassword');
        });

        // Gym Admin Routes
        Route::prefix('gym_admin')->middleware(['auth', 'role:gym_admin'])->name('gym_admin.')->group(function () {
            Route::get('/dashboard', [GymAdminDashboardController::class, 'index'])->name('dashboard');
            Route::resource('members', GymAdminMemberController::class)->names('members');
            Route::resource('staff', GymAdminStaffController::class)->names('staff');
            Route::resource('sports', GymAdminSportController::class)->names('sports');
            Route::resource('equipment', GymAdminEquipmentController::class)->names('equipment');
            Route::resource('expenses', GymAdminExpenseController::class)->names('expenses');
            Route::resource('memberships', GymAdminMembershipController::class)->names('memberships');
            Route::resource('payments', GymAdminPaymentController::class)->names('payments');
            Route::get('attendance', [GymAdminAttendanceController::class, 'index'])->name('attendance.index');
            Route::post('attendance/check-in', [GymAdminAttendanceController::class, 'checkIn'])->name('attendance.checkin');
            Route::post('attendance/check-out/{id}', [GymAdminAttendanceController::class, 'checkOut'])->name('attendance.checkout');
            Route::get('attendance/autocomplete', [GymAdminAttendanceController::class, 'autocomplete'])->name('attendance.autocomplete');

            // Profile Routes
            Route::get('/profile', [GymAdminProfileController::class, 'index'])->name('profile');
            Route::post('/profile', [GymAdminProfileController::class, 'update'])->name('profile.update');
            Route::post('/profile/deactivate', [GymAdminProfileController::class, 'deactivate'])->name('profile.deactivate');

            // Security Routes
            Route::get('/security', [GymAdminProfileController::class, 'security'])->name('security');
            Route::post('/security/password', [GymAdminProfileController::class, 'updatePassword'])->name('security.updatePassword');

            // Billing Routes
            Route::get('/billing', [GymAdminBillingController::class, 'index'])->name('billing');
            Route::get('/billing/show/{id}', [GymAdminBillingController::class, 'show'])->name('billing.show');

            // Settings Routes
            Route::get('/settings', [GymAdminSettingController::class, 'index'])->name('settings');
            Route::post('/settings', [GymAdminSettingController::class, 'update'])->name('settings.update');

        });

        // Staff Routes
        Route::prefix('staff')->middleware(['auth', 'role:staff'])->name('staff.')->group(function () {
            Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
            // Members: view only
            Route::resource('members', StaffMemberController::class)->names('members')->only(['index', 'show']);

            // Payments: create, view, edit (no delete)
            Route::resource('payments', StaffPaymentController::class)->names('payments')->except(['destroy']);

            // Equipment: view only
            Route::resource('equipment', StaffEquipmentController::class)->names('equipment')->only(['index', 'show']);

            // Attendance: view and mark attendance
            Route::get('attendance', [StaffAttendanceController::class, 'index'])->name('attendance.index');
            Route::post('attendance/check-in', [StaffAttendanceController::class, 'checkIn'])->name('attendance.checkin');
            Route::post('attendance/check-out/{id}', [StaffAttendanceController::class, 'checkOut'])->name('attendance.checkout');
            Route::get('attendance/autocomplete', [StaffAttendanceController::class, 'autocomplete'])->name('attendance.autocomplete');

            // Profile Routes
            Route::get('/profile', [StaffProfileController::class, 'index'])->name('profile');
            Route::post('/profile', [StaffProfileController::class, 'update'])->name('profile.update');
            Route::post('/profile/deactivate', [StaffProfileController::class, 'deactivate'])->name('profile.deactivate');

            // Security Routes
            Route::get('/security', [StaffProfileController::class, 'security'])->name('security');
            Route::post('/security/password', [StaffProfileController::class, 'updatePassword'])->name('security.updatePassword');

        });
    });
});

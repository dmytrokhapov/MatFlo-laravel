<?php

use App\Http\Controllers\AggregatorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FarmerVendorController;
use App\Http\Controllers\LandDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkFlowController;
use App\Http\Controllers\WorkspaceController;


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
Route::middleware('auth','verified')->group(function () {
    Route::post('/staffs/export',  [UserController::class, 'export'])->name('staffs.export')->middleware('adminRoutes');
    Route::post('/companies/export',  [CompanyController::class, 'export'])->name('companies.export');
    Route::post('/farmer-vendors/export',  [FarmerVendorController::class, 'export'])->name('farmerVendors.export');
    Route::post('/aggregators/export',  [AggregatorController::class, 'export'])->name('aggregators.export');
    Route::post('/land-details/export',  [LandDetailController::class, 'export'])->name('landDetails.export');
});
Route::group(['middleware' => 'preventBackHistory'], function () {
Route::get('/', function () {
    return view('auth.login');
})->middleware(['auth', 'verified','guest']);

// Route::get('/dashboard', function () {
//     Route::post('/d', [WorkspaceController::class,'export'])->name('export');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/view-batch/{batchNo}', [DashboardController::class,'viewBatch'])->name('viewBatch');
Route::get('/view-publish/{batchNo}', [DashboardController::class,'viewPublish'])->name('viewPublish');
Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('document.download');
Route::get('/documents/{document}/download_publish', [DocumentController::class, 'download_publish'])->name('document.download_publish');

Route::get('/explorer', [DashboardController::class,'explorer'])->name('explorer');
Route::get('/search', [DashboardController::class, 'search'])->name('search');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::middleware(['role:ADMIN,PRODUCER'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/publish', [DashboardController::class, 'publish'])->name('publish');
        Route::get('/apikey', [UserController::class, 'apikey'])->name('apikey');
    // });

    Route::post('/addkey', [UserController::class, 'add'])->name('addkey');
    Route::get('/apikey/{apikey}/deletekey', [UserController::class, 'delete'])->name('apikey.delete');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/change-password', [ProfileController::class, 'changepasswordFrom'])->name('profile.change-password');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/workspace/getUsersList', [WorkspaceController::class, 'getUsersList'])->name('getUsersList');

    //users routers
    Route::group(['middleware' => 'adminRoutes'], function () {
        //staff routes
        Route::get('/staffs', [UserController::class, 'index'])->name('staffs');
        Route::post('/getStaffList', [UserController::class, 'getStaffList'])->name('getStaffList');
        Route::delete('/deleteStaff/{id}', [UserController::class, 'destroy'])->name('deleteUser');
        Route::get('/staffs/create', [UserController::class, 'create'])->name('staffs.create');
        Route::post('/staffs/store', [UserController::class, 'store'])->name('staffs.store');
        Route::get('/staffs/{id}/edit', [UserController::class, 'edit'])->name('staffs.edit');
        Route::put('/staffs/update', [UserController::class, 'update'])->name('staffs.update');
        Route::post('/staffs/updateStatus', [UserController::class, 'updateStatus'])->name('staffs.updateStatus');
        // Update User
        Route::post('/updateUser', [UserController::class, 'updateUser'])->name('updateUser');
        Route::get('/documents/{document}/preview_publish', [DocumentController::class, 'preview_publish'])->name('admin.document.preview');
        Route::get('/documents/{document}/approve', [DocumentController::class, 'approve'])->name('document.approve');
        Route::get('/documents/{document}/reject_publish', [DocumentController::class, 'reject_publish'])->name('admin.document.reject');
    });

    // Producer-only routes
    Route::middleware(['producer'])->group(function () {

        // file upload route
        // Route::post('/dashboard/upload', [DocumentController::class, 'upload'])->name('dashboard.upload')->middleware('web');
        // Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('document.download');
    });

    Route::post('/dashboard/upload', [DocumentController::class, 'upload'])->name('dashboard.upload')->middleware('web');
    Route::post('/dashboard/publish', [DocumentController::class, 'publish'])->name('dashboard.publish')->middleware('web');
    Route::post('/dashboard/sign', [DocumentController::class, 'sign'])->name('dashboard.sign')->middleware('web');
    Route::post('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('document.edit');
    Route::get('/documents/{document}/delete', [DocumentController::class, 'delete'])->name('document.delete');
    Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])->name('verifier.document.preview');

    // Verifier-only routes
    Route::middleware(['verifier'])->group(function () {
    // Verifier routes here

        Route::get('/documents/{document}/accept', [DocumentController::class, 'accept'])->name('verifier.document.accept');
        // Route::get('/documents/{document}/sign', [DocumentController::class, 'sign'])->name('verifier.document.sign');
        Route::get('/documents/{document}/reject', [DocumentController::class, 'reject'])->name('verifier.document.reject');
        Route::get('/documents/{document}/verify', [DocumentController::class, 'show'])->name('verifier.document.verify');
    });

    //company routes
    Route::get('/workflow/create', [WorkFlowController::class, 'create'])->name('workflow.create');
    // Route::post('/workflow/store', [UserController::class, 'store'])->name('workflow.store');

    // Route::post('/getCompanyList', [WorkFlowController::class, 'getCompanyList'])->name('getCompanyList');
    // Route::delete('/deleteCompany/{id}', [WorkFlowController::class, 'destroy'])->name('deleteCompany');
    // Route::get('/companies/create', [WorkFlowController::class, 'create'])->name('companies.create');
    // Route::post('/companies/store', [WorkFlowController::class, 'store'])->name('companies.store');
    // Route::get('/companies/{id}/edit', [WorkFlowController::class, 'edit'])->name('companies.edit');
    // Route::put('/companies/update', [WorkFlowController::class, 'update'])->name('companies.update');
    // Route::post('/companies/updateStatus', [WorkFlowController::class, 'updateStatus'])->name('companies.updateStatus');
    });

require __DIR__.'/auth.php';

});
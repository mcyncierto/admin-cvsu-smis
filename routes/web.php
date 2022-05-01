<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\GpaCheckerController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\RequirementTypeController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('users', UserController::class)->middleware('auth')->middleware('admin');
Route::patch('/update/{id}', [UserController::class, 'update'])->name('users.update')->middleware('auth');
Route::resource('announcements', AnnouncementController::class)->middleware('auth');
Route::get('scholarships/view-attachment/{id}/{file_name}', [ScholarshipController::class, 'viewAttachment'])->name('scholarships.view-attachment');
Route::resource('scholarships', ScholarshipController::class)->middleware('auth');
Route::get('/requirement-types', [RequirementTypeController::class, 'index']);
Route::resource('gpa-checker', GpaCheckerController::class)->middleware('auth')->middleware('admin');

Route::group(['prefix' => 'inquiries'], function () {
    Route::get('/', [InquiryController::class, 'index'])->name('inquiries.index')->middleware('admin');
    Route::get('/create/{studentId?}', [InquiryController::class, 'create'])->name('inquiries.create');
    Route::post('/store', [InquiryController::class, 'store'])->name('inquiries.store');
});

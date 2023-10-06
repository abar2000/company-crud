<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('companies.index');
});

Route::get('/companies',[CompanyController::class, 'index'])->name("companies-index");
Route::get('/companies/create',[CompanyController::class, 'create'])->name("companies-create");
Route::post('/companies',[CompanyController::class,'store'])->name("companies-store");
Route::get('/companies/{id}/edit',[CompanyController::class,'edit'])->name("companies-edit");
Route::put('/companies/{id}',[CompanyController::class,'update'])->name("companies-update");
Route::delete('/companies/{id}',[CompanyController::class,'destroy'])->name("companies-destroy");

Route::get('/countries',[CompanyController::class, 'create'])->name("countries-create");
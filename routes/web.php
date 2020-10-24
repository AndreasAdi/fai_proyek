<?php

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
    return view('login');
});

Route::get('/home','user@home');
Route::view('/register', 'register');
Route::post('/cekregister', 'user@register');
Route::post('/ceklogin', 'user@login');
Route::view('/regisMerchant','registerMerchant');
Route::post('/prosesRegisterMerchant', 'user@prosesRegisterMerchant');
Route::get('/addItem',"barangController@loadPageTambahBarang");
Route::post('/prosesTambahBarang', "barangController@prosesTambahBarang");

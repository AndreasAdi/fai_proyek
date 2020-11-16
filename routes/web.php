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

// Route::get('/', function () {
//     return view('login');
// });


Route::get('/', function () {
    return view('loginBaru');
});

Route::get('/a', function () {
    return view('verifyEmail');
});

Route::prefix('user')->group(function(){
    Route::view('/register', 'register');
    Route::get('/home','user@home');
    Route::post('/cekregister', 'user@sendEmail');
    Route::view('/verifikasi', 'verifyEmail');
    Route::post('/prosesRegister', 'user@register');
    Route::post('/ceklogin', 'user@login');
    Route::view('/regisMerchant','registerMerchant');
    Route::post('/prosesRegisterMerchant', 'user@prosesRegisterMerchant');
    Route::get('/prosesLogout','user@prosesLogout');
    Route::get('/makeChatroom/{idMerchant}','user@makeChatroom');
    Route::get('/loadDetailChat/{id_chatroom}','user@loadDetailChat');
    Route::post('/insertDetail','user@sendChat');
    Route::get('/loadChatroom','user@loadChatroom');
    Route::get('/loadtoko/{id}','user@loadtoko');
    Route::get('/reviewMerchant/{idmerchant}','user@reviewMerchant');
    Route::get('/listVoucher','user@loadListVoucher');
    Route::get('/wishlist','user@loadwishlist');
    Route::get('/listSale','user@loadListSale');
    Route::get('/loadPageSale/{id_kategori}','user@loadPageSale');
    Route::post('/checkOut','user@checkOut');
    Route::get('/alamat','user@alamat');
    Route::post('/tambahAlamat','user@tambahAlamat');
    Route::get('/pembelian','user@pembelian');
    Route::get('/pembelian/{idhorder}','user@detailPembelian');
    Route::post('/bayar/{idhorder}','user@bayar');
    Route::get('/terima/{iddorder}','user@terima');
    Route::post('/review/{idmerchant}/{iddorder}','user@review');
    Route::get('/penjualan','user@penjualan');
    Route::post('/kirim/{iddorder}','user@kirim');
    Route::post('/filterDaftarPembelian',"user@filterPembelian");
    Route::post('/searchChat',"user@searchChat");
});

Route::prefix('barang')->group(function(){
    Route::get('/addItem',"barangController@loadPageTambahBarang");
    Route::post('/prosesTambahBarang', "barangController@prosesTambahBarang");
    Route::get('/detailBarang/{id}','barangController@detail');
    Route::post('/searchBarang','barangController@searchBarang');
    Route::get('/cart',"barangController@loadCart");
    Route::get('/yourItem',"barangController@loadItem");
    Route::get('/editBarang/{id}','barangController@editBarang');
    Route::get('/addToWishlist/{id_barang}','barangController@AddToWishlist');
    Route::get('/RemoveFromWishlist/{id_barang}','barangController@RemoveFromWishlist');
    Route::patch('/prosesEditBarang','barangController@prosesEditBarang');
    Route::post('/addToCart',"barangController@AddToCart");
    Route::delete('/NonAktifBarang/{id}','barangController@deleteBarang');
    Route::patch('/aktifkanBarang/{id}','barangController@aktifkanBarang');
    Route::get('/removeItemCart/{id}',"barangController@removeItemCart");
    Route::get('/editItemCart/{id}',"barangController@editItemCart");
    Route::post('/filterBarang',"barangController@Filter");
});

Route::prefix('admin')->group(function(){
    Route::view('/home','adminHome');
    Route::get('/listVoucher','VoucherController@loadListVoucher');
    Route::get('/listSale','saleController@loadListSale');
    Route::get('/konfirmasi','saleController@konfirmasi');
    Route::get('/konfirmasi/{idhorder}','saleController@konfirmasiOrder');
});

Route::prefix('voucher')->group(function(){
    Route::get('/addVoucher','VoucherController@loadAddVoucher');
    Route::patch('/AktifkanVoucher/{id_voucher}','VoucherController@aktifkanVoucher');
    Route::delete('/NonAktifkanVoucher/{id_voucher}','VoucherController@deleteVoucher');
    Route::post('/TambahVoucher','VoucherController@makeVoucher');
});

Route::prefix('sale')->group(function(){
    Route::get('/addSale','saleController@loadAddSale');
    Route::patch('/AktifkanSale/{id_sale}','saleController@aktifkanSale');
    Route::delete('/NonAktifkanSale/{id_sale}','saleController@deleteSale');
    Route::post('/TambahSale','saleController@addSale');
});

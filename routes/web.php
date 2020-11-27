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


Route::get('/', 'user@home');
Route::get('/login', function () {
    return view('loginBaru');
});
Route::get('/a', function () {
    return view('verifyEmail');
});
Route::post('/user/prosesRegister', 'user@register');
Route::post('/user/ceklogin', 'user@login');
Route::post('/user/cekregister', 'user@sendEmail');
Route::view('/user/verifikasi', 'verifyEmail');
Route::view('/user/register', 'register');
Route::get('/user/loadtoko/{id}','user@loadtoko');
Route::get('/user/reviewMerchant/{idmerchant}','user@reviewMerchant');

Route::group(['prefix' => 'user',  'middleware' => 'AuthLogin'], function() {
    Route::get('/home','user@home');
    Route::view('/regisMerchant','registerMerchant');
    Route::post('/prosesRegisterMerchant', 'user@prosesRegisterMerchant');
    Route::get('/prosesLogout','user@prosesLogout');
    Route::get('/makeChatroom/{idMerchant}','user@makeChatroom');
    Route::get('/loadDetailChat/{id_chatroom}','user@loadDetailChat');
    Route::post('/insertDetail','user@sendChat');
    Route::get('/loadChatroom','user@loadChatroom');
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
    Route::post('/report/{idmerchant}/{iddorder}','user@report');
    Route::get('/penjualan','user@penjualan');
    Route::post('/kirim/{iddorder}','user@kirim');
    Route::post('/filterDaftarPembelian',"user@filterPembelian");
    Route::post('/filterDaftarPenjualan',"user@filterPenjualan");
    Route::post('/searchChat',"user@searchChat");
    Route::post('/useVoucher',"user@useVoucher");
    Route::get('/markAsRead/{idnotifikasi}',"user@markAsRead");
    Route::get('/reportPenjualan','user@reportPenjualan');
    Route::post('/prosesReportPenjualan','user@prosesReportPenjualan');
});
Route::get('/barang/detailBarang/{id}','barangController@detail');
Route::post('barang/searchBarang','barangController@searchBarang');

Route::group(['prefix' => 'barang',  'middleware' => 'AuthLogin'], function() {
    Route::get('/addItem',"barangController@loadPageTambahBarang");
    Route::post('/prosesTambahBarang', "barangController@prosesTambahBarang");
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

Route::group(['prefix' => 'admin',  'middleware' => 'AuthLogin'], function() {
    Route::view('/home','adminHome');
    Route::get('/listVoucher','VoucherController@loadListVoucher');
    Route::get('/listSale','saleController@loadListSale');
    Route::get('/konfirmasi','saleController@konfirmasi');
    Route::get('/konfirmasi/{idhorder}','saleController@konfirmasiOrder');
    Route::get('/konfirmasiReport','saleController@konfirmasiReport');
    Route::get('/konfirmasiReport/{idreport}/{idhorder}','saleController@konfirmReport');
    Route::get('/rejectReport/{idreport}/{idhorder}','saleController@rejectReport');
    Route::get('/addKategori','kategoriController@addKategori');
    Route::post('/TambahKategori','kategoriController@tambahKategori');
    Route::get('/listKategori','kategoriController@loadListKategori');
    Route::get('/deleteKategori/{idkategori}','kategoriController@deleteKategori');
});

Route::group(['prefix' => 'voucher',  'middleware' => 'AuthLogin'], function() {
    Route::get('/addVoucher','VoucherController@loadAddVoucher');
    Route::patch('/AktifkanVoucher/{id_voucher}','VoucherController@aktifkanVoucher');
    Route::delete('/NonAktifkanVoucher/{id_voucher}','VoucherController@deleteVoucher');
    Route::post('/TambahVoucher','VoucherController@makeVoucher');
});

Route::group(['prefix' => 'sale',  'middleware' => 'AuthLogin'], function() {
    Route::get('/addSale','saleController@loadAddSale');
    Route::patch('/AktifkanSale/{id_sale}','saleController@aktifkanSale');
    Route::delete('/NonAktifkanSale/{id_sale}','saleController@deleteSale');
    Route::post('/TambahSale','saleController@addSale');
});

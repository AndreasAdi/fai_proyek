<?php

namespace App\Http\Controllers;

use App\Models\sale;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\kategoribarang;

class saleController extends Controller
{
    public function addSale(Request $request){
        $masaBerlaku= Carbon::parse($request->tanggal_habis);
        $addSale=new sale;
        $addSale->nama_sales=$request->nama_sales;
        $addSale->tanggal_habis=$masaBerlaku->format('Y-m-d H:i:s');
        $addSale->id_kategori=$request->id_kategori;
        $addSale->save();
        if($addSale){
            return redirect()->back()->with('success','Berhasil Menambah Sale');
        }else{
            return redirect()->back()->with('error','Gagal Menambah Sale');
        }
    }

    public function loadAddSale(Request $request){
        $dataKategori=kategoribarang::all();
        $dataKategori=json_decode(json_encode($dataKategori),true);
        return view('addSale',[
            'dataKategori'=>$dataKategori
        ]);
    }

    public function loadListSale(){
        $listSale=sale::withTrashed()->get();
        return view('listSaleAdmin',['listSale'=>$listSale]);
    }

    public function deleteSale($id_sale){
        $deleteSale=sale::findOrFail($id_sale);
        $delete=$deleteSale->delete();
        if($delete){
            return redirect()->back()->with('success','Sale Berhasil Di Non-Aktifkan');
        }else{
            return redirect()->back()->with('error','Sale Gagal Di Non-Aktifkan');
        }
    }

    public function aktifkanSale($id_sale){
        $saleAkanDiAktifkan= sale::withTrashed()->findOrFail($id_sale);
        $aktifkan=$saleAkanDiAktifkan->restore();
        if($aktifkan){
            return redirect()->back()->with('success','Sale Berhasil Di Aktifkan');
        }else{
            return redirect()->back()->with('error','Sale Gagal Di Aktifkan');
        }
    }
}

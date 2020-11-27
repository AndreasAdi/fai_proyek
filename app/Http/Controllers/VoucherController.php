<?php

namespace App\Http\Controllers;

use App\Models\kategoribarang;
use App\Models\voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VoucherController extends Controller
{
    public function makeVoucher(Request $request){

        $masaBerlaku= Carbon::parse($request->MasaBerlaku);
        $newVoucher= new voucher;
        $newVoucher->id_kategori= $request->kategori;
        $newVoucher->kode_voucher= $request->kodeVoucher;
        $newVoucher->nama_voucher=$request->namaVoucher;
        $newVoucher->diskon=$request->diskon;
        $newVoucher->masa_berlaku=$masaBerlaku->format('Y-m-d H:i:s');
        $newVoucher->save();

        if($newVoucher){
            return redirect()->back()->with('success','Berhasil menambahkan voucher baru');
        }else{
            return redirect()->back()->with('error','Gagal menambahkan voucher baru');
        }
    }

    public function loadAddVoucher(){
        $dataKategori=kategoribarang::all();    
        $dataKategori=json_decode(json_encode($dataKategori),true);
        return view('addVoucher',[
            'dataKategori'=>$dataKategori
        ]);
    }
    public function loadListVoucher(){
        $listVoucher=voucher::withTrashed()->get();
        return view('VoucherAdmin',['listVoucher'=>$listVoucher]);
    }
    public function deleteVoucher($id_voucher){
        $deleteVoucher=voucher::findOrFail($id_voucher);
        $delete=$deleteVoucher->delete();
        if($delete){
            return redirect()->back()->with('success','Voucher Berhasil Di Non-Aktifkan');
        }else{
            return redirect()->back()->with('error','Voucher Gagal Di Non-Aktifkan');
        }
    }
    public function aktifkanVoucher($id_voucher){
        $voucherAkanDiAktifkan= voucher::withTrashed()->findOrFail($id_voucher);
        $aktifkan=$voucherAkanDiAktifkan->restore();
        if($aktifkan){
            return redirect()->back()->with('success','Voucher Berhasil Di Aktifkan');
        }else{
            return redirect()->back()->with('error','Voucher Gagal Di Aktifkan');
        }
    }
}

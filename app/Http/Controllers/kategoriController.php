<?php

namespace App\Http\Controllers;

use App\Models\kategoribarang;
use Illuminate\Http\Request;

class kategoriController extends Controller
{
    //
    public function addKategori() {
        return view("addKategori");
    }
    public function tambahKategori(Request $req) {
        $kategori = new kategoribarang;
        $kategori->nama_kategori = $req->nama;
        $kategori->save();

        if($kategori){
            return redirect()->back()->with('success','Berhasil menambahkan kategori baru');
        }else{
            return redirect()->back()->with('error','Gagal menambahkan kategori baru');
        }
    }
    public function loadListKategori(){
        $listKategori= kategoribarang::all();
        return view('kategoriAdmin',['listKategori'=>$listKategori]);
    }
    public function deleteKategori($idkategori) {
        $kategori = kategoribarang::where('id_kategori',$idkategori)->first();
        $kategori->delete();

        return redirect()->back()->with('success','Berhasil delete kategori');
    }

}

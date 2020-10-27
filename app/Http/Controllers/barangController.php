<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\kategoribarang;
use App\Models\merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class barangController extends Controller
{
    public function loadPageTambahBarang(){
        $dataKategori=kategoribarang::all();
        $dataKategori=json_decode(json_encode($dataKategori),true);
        return view('tambahBarang',[
            'dataKategori'=>$dataKategori
        ]);
    }

    public function prosesTambahBarang(Request $request){
        $inputBarang=$request->validate([
            "namaBarang"=>'required',
            "hargaBarang"=>'required|integer',
            'stokBarang'=>'required|integer',
            'hargaSale'=>'integer',
            'deskripsiBarang'=>'required|max:2000'
        ]);
        $idMerchant=merchant::where('id_user',$request->session()->get('userId'))->first();
        $insertNewItem= new barang;
        $insertNewItem->id_merchant=$idMerchant->id_merchant;
        $insertNewItem->id_kategori=$request->kategori;
        $insertNewItem->nama_barang=$inputBarang['namaBarang'];
        $insertNewItem->harga=$inputBarang['hargaBarang'];
        $insertNewItem->stok=$inputBarang['stokBarang'];
        $insertNewItem->deskripsi_barang=$inputBarang['deskripsiBarang'];
        $insertNewItem->harga_sale=$inputBarang['hargaSale'];
        $insertNewItem->status_barang="no-sale";
        $insertNewItem->save();
        if($insertNewItem){
            $nama = $insertNewItem->id_barang.".".$request->file("gambar")->getClientOriginalExtension();
            $request->file("gambar")->storeAs("images", $nama, "public");
            $insertNewItem->gambar_barang = $nama;
            $insertNewItem->save();
            return redirect()->back()->with('success','Berhasil Menambah barang');
        }else{
            return redirect()->back()->with('error','Gagal Menambah Barang');
        }
    }

    public function detail ($id){
        $barang = DB::table('barang')->where("id_barang",$id)
        ->Join('merchant', 'barang.id_merchant', '=', 'merchant.id_merchant')->first();
        return view("detailBarang",["barang" =>$barang]);
    }

    public function searchBarang(Request $request){
        $dataSearch=barang::query()->
        where(DB::raw("UPPER(nama_barang)"), "like", "%".\strtoupper($request->searchKeyword)."%")
        ->paginate(6);
        //dd($dataSearch);
        return view('searchBarang',[
            'dataBarang'=>$dataSearch
        ]);
    }

    public function AddToCart(Request $request){
        $userLogin=Session::get("userId");
        if($request->jumlah<=$request->stok){
            if(!Session::has("cart_$userLogin")){
                $cart=array(
                    "0"=>[
                        "idBarang"=>$request->idBarang,
                        "idMerchant"=>$request->idMerchant,
                        "jumlah"=>$request->jumlah,
                        "namaBarang"=>$request->nama,
                        "harga"=>$request->harga
                ]);
                Session::put("cart_$userLogin",$cart);
            }else{
                $existingCart=Session::get("cart_$userLogin");
                $existingCart=json_decode(json_encode($existingCart),true);
                $itemKembar=false;
                foreach($existingCart as $key =>$item){
                    if($item['idBarang']==$request->idBarang){
                        if($item['jumlah']+$request->jumlah<=$request->stok){
                            $existingCart[$key]['jumlah']=$item['jumlah']+$request->jumlah;
                            $itemKembar=true;
                        }else{
                            return redirect("barang/detailBarang/$request->idBarang")->with('error','Jumlah Permintaan Anda Lebih Besar Dari Stok');
                        }
                    }
                }
                if(!$itemKembar){
                    $cart=array(
                        "idBarang"=>$request->idBarang,
                        "idMerchant"=>$request->idMerchant,
                        "jumlah"=>$request->jumlah,
                        "namaBarang"=>$request->nama,
                        "harga"=>$request->harga
                    );
                    $existingCart[]=$cart;
                }
                Session::put("cart_$userLogin",$existingCart);
            }
            return redirect("barang/detailBarang/$request->idBarang")->with('success','Berhasil Menambahkan Barang Kedalam Cart');
        }else{
            return redirect("barang/detailBarang/$request->idBarang")->with('error','Jumlah Permintaan Anda Lebih Besar Dari Stok');
        }


    }
    public function loadCart(Request $request){
        $userLogin=Session::get("userId");
        $customerCart= Session::get("cart_$userLogin");
        $customerCart= json_decode(json_encode($customerCart),true);
        return view('cart',[
            "dataCart"=>$customerCart
        ]);
    }
}

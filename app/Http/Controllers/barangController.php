<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\kategoribarang;
use App\Models\merchant;
use App\Models\wishlist;
use App\Models\alamatpengiriman;
use App\Models\reviewmerchant;
use App\Models\notifikasi;
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
            $path = $request->file("gambar")->storeAs("images", $nama, "public");
            $insertNewItem->gambar_barang = $nama;
            $insertNewItem->save();
            return redirect()->back()->with('success','Berhasil Menambah barang');
        }else{
            return redirect()->back()->with('error','Gagal Menambah Barang');
        }
    }

    public function detail ($id,$status){
        $userLogin=Session::get("userId");
        $barang = DB::table('barang')->where("id_barang",$id)
        ->Join('merchant', 'barang.id_merchant', '=', 'merchant.id_merchant')->first();
        $wishlist = wishlist::where('id_user',$userLogin)->where('id_barang',$id)->get();
        if (count($wishlist)==0){
            //dd($wishlist);
            if($status=="sale"){
                return view("detailBarang",["barang" =>$barang,"status"=>"sale"]);
            }else{
                return view("detailBarang",["barang" =>$barang,"status"=>"normal"]);
            }
        }
        else if(count($wishlist)==1){
            if($status=="sale"){
                return view("detailBarang",["barang" =>$barang,"status"=>"sale","wishlist"=>$wishlist]);
            }else{
                return view("detailBarang",["barang" =>$barang,"status"=>"normal","wishlist"=>$wishlist]);
            }
        }
    }

    public function searchBarang(Request $request){
        $status=$request->status;

        if($status=='normal'){
            if(Session::get("isMerchant")===false){
                $dataSearch=barang::query()->
                where(DB::raw("UPPER(nama_barang)"), "like", "%".\strtoupper($request->searchKeyword)."%")
                ->paginate(6);
            }else{
                $dataSearch=barang::query()->
                where(DB::raw("UPPER(nama_barang)"), "like", "%".\strtoupper($request->searchKeyword)."%")->
                where('id_merchant',"!=",Session::get('MerchantId'))
                ->paginate(6);
            }
            return view('searchBarang',[
                'dataBarang'=>$dataSearch,
                "status"=>"normal"
            ]);
        }else if($status=="sale"){
            $id_kategori=$request->kategori;
            if(Session::get("isMerchant")===false){
                $dataSearch=barang::query()->
                where(DB::raw("UPPER(nama_barang)"),"like", "%".\strtoupper($request->searchKeyword)."%")->
                where("id_kategori",$id_kategori)
                ->paginate(6);
            }else{
                $dataSearch=barang::query()->
                where(DB::raw("UPPER(nama_barang)"), "like", "%".\strtoupper($request->searchKeyword)."%")->
                where("id_kategori",$id_kategori)->
                where('id_merchant',"!=",Session::get('MerchantId'))
                ->paginate(6);
            }
            return view('pageSaleUser',[
                'listBarangSale'=>$dataSearch,
                "status"=>"sale",
                "id_kategori"=>$id_kategori
            ]);
        }
    }

    public function AddToCart(Request $request){
        $userLogin=Session::get("userId");
        $status=$request->status;
        if($request->jumlah<=$request->stok){
            if(!Session::has("cart_$userLogin")){
                $cart=array(
                    "0"=>[
                        "idBarang"=>$request->idBarang,
                        "idMerchant"=>$request->idMerchant,
                        "jumlah"=>$request->jumlah,
                        "gambar"=>$request->gambar,
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
                           if($status=="sale"){
                                return redirect("barang/detailBarang/$request->idBarang/sale")->with('error','Jumlah Permintaan Anda Lebih Besar Dari Stok');
                            }else{
                                return redirect("barang/detailBarang/$request->idBarang/normal")->with('error','Jumlah Permintaan Anda Lebih Besar Dari Stok');
                            }
                        }
                    }
                }
                if(!$itemKembar){
                    $cart=array(
                        "idBarang"=>$request->idBarang,
                        "idMerchant"=>$request->idMerchant,
                        "jumlah"=>$request->jumlah,
                        "gambar"=>$request->gambar,
                        "namaBarang"=>$request->nama,
                        "harga"=>$request->harga
                    );
                    $existingCart[]=$cart;
                }
                Session::put("cart_$userLogin",$existingCart);
            }
            if($status=="sale"){
                return redirect("barang/detailBarang/$request->idBarang/sale")->with('success','Berhasil Menambahkan Barang Kedalam Cart');
            }else{
                return redirect("barang/detailBarang/$request->idBarang/normal")->with('success','Berhasil Menambahkan Barang Kedalam Cart');
            }
        }else{
            if($status=="sale"){
                return redirect("barang/detailBarang/$request->idBarang/sale")->with('error','Jumlah Permintaan Anda Lebih Besar Dari Stok');
            }else{
                return redirect("barang/detailBarang/$request->idBarang/normal")->with('error','Jumlah Permintaan Anda Lebih Besar Dari Stok');
            }
        }
    }
    public function removeItemCart($id){
        $userLogin=Session::get("userId");
        $cartUser=Session::get("cart_$userLogin");
        unset($cartUser[$id]);
        if(count($cartUser)<1){
            Session::forget("cart_$userLogin");
        }else{
            Session::put("cart_$userLogin",$cartUser);
        }
        return redirect("barang/cart")->with('success','Berhasil Menghapus Barang Dari Cart');
    }
    public function editItemCart(Request $request,$id){
        $userLogin=Session::get("userId");
        $cartUser=Session::get("cart_$userLogin");
        $cartTemp=$cartUser[$id];
        $cartTemp['jumlah']=$request->jumlah;
        $cartUser[$id]=$cartTemp;
        Session::put("cart_$userLogin",$cartUser);
        return redirect("barang/cart")->with('success','Berhasil Edit Barang Dari Cart');
    }
    public function AddToWishlist($id_barang){
        $userLogin=Session::get("userId");
        $addwishlist= new wishlist;
        $addwishlist->id_user = $userLogin;
        $addwishlist->id_barang = $id_barang;
        $success = $addwishlist->save();

        if ($success){
            return redirect()->back()->with('success','Berhasil Menambahkan Barang Ke Wishlists');
        }
        else{
            return redirect()->back()->with('error','Gagal Menambahkan Barang Ke Wishlists');
        }

    }

    public function RemoveFromWishlist($id_barang){
        $userLogin=Session::get("userId");
        $success = wishlist::where('id_user',$userLogin)->where('id_barang',$id_barang)->delete();

        if ($success){
            return redirect()->back()->with('success','Berhasil Menghapus Barang Ke Wishlists');
        }
        else{
            return redirect()->back()->with('error','Gagal Menghapus Barang Ke Wishlists');
        }

    }

    public function loadCart(Request $request){
        $userLogin=Session::get("userId");
        $customerCart= Session::get("cart_$userLogin");
        $alamat = alamatpengiriman::where('id_user',$userLogin)->get();
        $customerCart= json_decode(json_encode($customerCart),true);
        return view('cart',[
            "dataCart"=>$customerCart,
            "alamat"=>$alamat
        ]);
    }
    public function loadItem(){
        $idMerchant=merchant::where('id_user',Session::get('userId'))->first();
        $countReview = reviewmerchant::where('id_merchant', $idMerchant->id_merchant)->count();
        $Review =reviewmerchant::where('id_merchant', $idMerchant->id_merchant)->get();
        $jumlahReview = 0;
        $ratarata = 0;
        foreach ($Review as $key => $value) {
            $jumlahReview = $jumlahReview + $value->score;
        }
        if ($countReview>0){
                $ratarata = $jumlahReview / $countReview;
        }
        else if($countReview<=0){
             $ratarata = $jumlahReview;
        }
    
        //dd($ratarata);
        $idMerchant=merchant::where('id_user',Session::get('userId'))->first();

        $idMerchant->rating_merchant = $ratarata;
        $idMerchant->save();
        $dataItem=barang::where('id_merchant',$idMerchant->id_merchant)->get();

        $dataItem=barang::withTrashed()->where('id_merchant',$idMerchant->id_merchant)->get();

        //$dataItem=json_decode(json_encode($dataItem),true);
        return view('listItem',[
            'dataItem'=>$dataItem,
            'dataMerchant'=>$idMerchant
        ]);
    }

    public function editBarang($id){
        $dataEdit=barang::withTrashed()->where('id_barang',$id)->first();
        $dataEdit=json_decode(json_encode($dataEdit),true);
        $dataKategori=kategoribarang::all();
        $dataKategori=json_decode(json_encode($dataKategori),true);
        return view('editBarang',['dataEdit'=>$dataEdit, 'dataKategori'=>$dataKategori]);
    }
    public function prosesEditBarang(Request $request){
        $dataBarang=barang::withTrashed()->where('id_barang',$request->idBarang)->first();
        $dataBarang->nama_barang=$request->namaBarang;
        $dataBarang->harga=$request->hargaBarang;
        $dataBarang->stok=$request->stokBarang;
        $dataBarang->harga_sale=$request->hargaSale;
        $dataBarang->deskripsi_barang=$request->deskripsiBarang;
        $dataBarang->save();
        if($dataBarang){
            if($request->gambar!=null){
                $nama = $dataBarang->id_barang.".".$request->file("gambar")->getClientOriginalExtension();
                $request->file("gambar")->storeAs("images", $nama, "public");
                $dataBarang->gambar_barang = $nama;
                $dataBarang->save();
            }

            return redirect('barang/yourItem')->with("success",'Barang Berhasil Di Edit');
        }
        else{
            return redirect('barang/yourItem')->with("error",'Barang Gagal Di Edit');
        }
    }
    public function deleteBarang($id){
        $barangDiDelete=barang::findOrFail($id);
        $delete=$barangDiDelete->delete();
        if($delete){
            return redirect()->back()->with('success','Barang Berhasil Di Non-Aktifkan');
        }else{
            return redirect()->back()->with('error','Barang Gagal Di Non-Aktifkan');
        }
    }
    public function aktifkanBarang($id){
        $dataBarang=barang::withTrashed()->findOrFail($id);
        $dataBarang->restore();
        if($dataBarang){
            return redirect()->back()->with("success",'Barang Berhasil Di Aktifkan');
        }
        else{
            return redirect()->back()->with("error",'Barang Gagal Di Aktifkan');
        }
    }

    public function Filter(Request $request){
             $min = $request->hargamin;
        $max = $request->hargamax;

        if($request->hargamax==null){
            $max =99999999;
        }

        if($request->hargamin==null){
            $min =0;
        }

        $filterResult=barang::where('id_kategori',$request->selectedKategori)->where('id_merchant',"!=",Session::get('MerchantId'))->whereBetween('harga',[$min,$max])->paginate(6);
        $dataCategori= kategoribarang::all();
         $userLogin=Session::get("userId");
          $dataNotifikasi = notifikasi::where('id_user',$userLogin)->where('status','unread')->get();
        return view("home2",['dataBarang'=>$filterResult,'dataKategori'=>$dataCategori,'dataNotifikasi'=>$dataNotifikasi]);
    }
}

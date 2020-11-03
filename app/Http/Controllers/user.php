<?php

namespace App\Http\Controllers;

use App\merchant as AppMerchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\merchant;
use App\Models\users;
use App\Models\barang;
use App\Models\chat;
use App\Models\chatroom;
use App\Models\kodeverifikasi;
use App\Models\voucher;
use App\Models\kategoribarang;
use App\Models\sale;
use App\Models\wishlist;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class user extends Controller
{
    public function register(Request $req){
        $kode=$req->validate([
            'verCode'=>'required|size:10'
        ]);
        $selectKode=kodeverifikasi::where('kode',$kode['verCode'])->where('status','true')->count();
        if($selectKode>0){
            $dataUser=json_decode(json_encode(Session::get('dataUser')),true);
            $insertNewUsers= new users;
            $insertNewUsers->email= $dataUser['email'];
            $insertNewUsers->password=$dataUser['password'];
            $insertNewUsers->nama_user=$dataUser['nama_user'];
            $insertNewUsers->saldo=0;
            $insertNewUsers->save();
            $updateKode=kodeverifikasi::where('kode',Session::get('verificationCode'))->where('status','true')->first();
            $updateKode->status='false';
            $updateKode->save();
            if($insertNewUsers){
                return redirect("/")->with('success','Berhasil Mendaftar');
            }else{
                return redirect()->back()->with('error','Gagal Mendaftar, Silahkan Cek Kembali Ke-Form Pendaftaran');
            }
        }else{
            return redirect()->back()->with('error','Kode Verifikasi Salah, Silahkan Cek Kembali Kode Verifikasi anda');
        }
    }

    public function sendEmail(Request $req){
        $validateData = $req->validate(
            [
                'email' => 'required|email|unique:users,email',
                'nama_user'=>'required',
                'password' => array(
                    'required',
                    'regex:/(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,}/'
                ),
                'kpassword'=> 'same:password',
            ],
            [
                "nama.required" =>"Username tidak boleh kosong",
                "email.unique" =>"email sudah terdaftar",
                "kpassword.same" =>"Confirm password harus sama dengan password",
                "password.regex"=>"Password minimal 5 character dan mengandung minimal 1 angka"
            ]
        );
        $nama = $validateData["nama_user"];
        $email = $validateData["email"];
        $kodeVerifikasi="";
        $data = users::where('email',$email)->count();
        if($data<=0){
            for($i=0;$i<10;$i++){
                $kodeVerifikasi.=strval(rand(0,9));
            }
            $verif= new kodeverifikasi;
            $verif->kode=$kodeVerifikasi;
            $verif->status="true";
            $verif->save();
            Session::put('verificationCode',$kodeVerifikasi);
            $verifycode=array('kodeVerifikasi'=>$kodeVerifikasi);
            Mail::send('Mail.mailTemplate', $verifycode, function ($message) use($email,$nama){
                $message->from('estoreproject2020@gmail.com', 'E-Store');
                $message->to($email, $nama);
                $message->subject('Account Verification Code');
            });
            $dataUser=array(
                'email'=>$req->email,
                'password'=>password_hash($req->password, \PASSWORD_DEFAULT),
                'nama_user'=>$req->nama_user
            );
            Session::put('dataUser',$dataUser);
            return redirect('user/verifikasi')->with('success','Kode Verifikasi Telah Dikirim Ke E-mail Anda,Silahkan Masukan Kode Verifikasi');
        }
        else{
            return redirect()->back()->with('error','Email Sudah Terdaftar, Silahkan Gunakan Email Lainnya');
        }


    }

    public function loadwishlist(){
        $userLogin=Session::get("userId");
        $listwishlist =wishlist::where("id_user",$userLogin)->join('barang', 'wishlist.id_barang', '=', 'barang.id_barang')->get();

        //dd($listwishlist);
        return view('wishlist',[
            "wishlist"=>$listwishlist
        ]);
    }

    public function loadtoko($id){
        $idMerchant=merchant::where('id_merchant',$id)->first();
        //dd($idMerchant);
        $dataItem=barang::where('id_merchant',$idMerchant->id_merchant)->get();

        //$dataItem=json_decode(json_encode($dataItem),true);
        return view('halamanToko',[
            'dataItem'=>$dataItem,
            'dataMerchant'=>$idMerchant
        ]);
    }

    public function login(Request $req)
    {
        if($req->email!='admin'&&$req->password!='admin'){
            $email = $req->email;
            $password = $req->password;
            $data = DB::table('users')->where('email',$email)->count();
            if($data>0){
                $dataUser = DB::table('users')->where('email',$email)->get();
                $dataUser=json_decode(json_encode($dataUser),true);
                if(Hash::check($password, $dataUser[0]['password'])){
                    Session::put("active",$email);
                    $cekAccMerchant=merchant::where("id_user",$dataUser[0]["id"])->count();
                    if($cekAccMerchant>0){
                        $cekIdMerchant=merchant::where("id_user",$dataUser[0]["id"])->first();
                        Session::put("isMerchant",true);
                        Session::put('MerchantId',$cekIdMerchant->id_merchant);
                        Session::put("isAdmin",false);
                    }else{
                        Session::put("isMerchant",false);
                        Session::put("isAdmin",false);
                    }
                    if($req->remember==true){
                        Session::put("remember",$email);
                    }
                    Session::put("userId",$dataUser[0]['id']);
                    return redirect('user/home');
                }else{
                    return redirect()->back()->with('error','Email Atau Password Salah, Silahkan Cek Kembali Email dan Password Anda');
                }
            }
            else{
                return redirect()->back()->with('error','User Tidak Ditemukan, Silahkan Cek Kembali Email dan Password Anda');
            }
        }else{
            Session::put("isAdmin",true);
            return redirect('admin/home');
        }

    }
    public function loadListVoucher(){
        $listVoucher=voucher::all();
        return view('listVoucherUser',['listVoucher'=>$listVoucher]);
    }
    public function home(Request $req){
        if($req->session()->get('isMerchant')===false){
            $dataBarang=barang::paginate(6);
        }else{
            $dataMechant=merchant::where("id_user",$req->session()->get("userId"))->first();
            $dataBarang=barang::where("id_merchant","!=",$dataMechant->id_merchant)->paginate(6);
        }
        $dataCategori= kategoribarang::all();
        return view("home2",['dataBarang'=>$dataBarang,'dataKategori'=>$dataCategori]);
    }


    public function regisMerchant(){
        return view('registerMerchant');
    }

    public function prosesLogout(){
        Session::forget('userId');
        Session::forget('remember');
        Session::forget('active');
        return redirect('/');
    }

    public function prosesRegisterMerchant(Request $request){
        $cekMerchant=merchant::where('id_user',$request->session()->get('userId'))->count();
        if($cekMerchant>0){
            return redirect()->back()->with('error','Akun anda sudah terdaftar sebagai merchant');
        }else{
            $insertNewMerchant= new merchant;
            $insertNewMerchant->id_user=$request->session()->get('userId');
            $insertNewMerchant->nama_merchant=$request->regMerchant_nama;
            $insertNewMerchant->alamat_merchant=$request->regMerchant_alamat;
            $insertNewMerchant->rating_merchant='0';
            $insertNewMerchant->save();
            if($insertNewMerchant){
                return redirect()->back()->with('success','Berhasil Mendaftarkan Account Sebagai Merchant');
            }else{
                return redirect()->back()->with('error','Gagal Mendaftarkan Account Sebagai Merchant');
            }
        }
    }

    public function makeChatroom($idMerchant){
        $dataChatRoom = chatroom::where('id_sender',Session::get('userId'))->where('id_recepient',$idMerchant)->orWhere('id_sender',$idMerchant)->where('id_recepient',Session::get('userId'))->first();
        if ($dataChatRoom != null) {
            return redirect("user/loadDetailChat/$dataChatRoom->id_chatroom");
        }
        $makeChatroom=new chatroom;
        $makeChatroom->id_sender=Session::get('userId');
        $makeChatroom->id_recepient=$idMerchant;
        $makeChatroom->save();
        if($makeChatroom){
            $id_chatroom=chatroom::where('id_sender',Session::get('userId'))->where('id_recepient',$idMerchant)->first();
            return redirect("user/loadDetailChat/$id_chatroom->id_chatroom")->with('success','Chat Room Berhasil Di Buat');
        }else{
            return redirect()->back()->with('error','Chat Room Gagal Di buat');
        }
    }

    public function loadChatroom(){
        $dataChatroom=chatroom::where('id_sender',Session::get('userId'))->orWhere('id_recepient',Session::get('userId'))->get();
        $count = count($dataChatroom);
        $datanama = [];
        for ($i=0; $i < $count; $i++) { 
            if(users::find($dataChatroom[$i]->id_sender)->id == Session::get('userId')) {
                $dataNama[] = users::find($dataChatroom[$i]->id_recepient);
            }
            else {
                $dataNama[] = users::find($dataChatroom[$i]->id_sender);
            }
        }
        //$dataChatroom=json_decode(json_encode($dataChatroom),true);
        if (isset($dataNama)) {
            $dataNama=json_decode(json_encode($dataNama),true);
            return view('chatroom',['headerChat'=>$dataChatroom, 'nama'=>$dataNama]);
        }
        else {
            return view('chatroom',['headerChat'=>$dataChatroom]);
        }
        
    }

    public function loadDetailChat($id_chatroom){
        $chatDetail=chat::where('id_chatroom',$id_chatroom)->get();
        $chatDetail=json_decode(json_encode($chatDetail),true);
        $chatroom=chatroom::where('id_chatroom',$id_chatroom)->first();
        $recepient=users::where('id',$chatroom->id_recepient)->first();
        $sender=users::where('id',$chatroom->id_sender)->first();

        return view('chatDetail',[
            'detailChat'=>$chatDetail,
            'idChatroom'=>$id_chatroom,
            'id_sender'=>$chatroom->id_sender,
            'id_recepient'=>$chatroom->id_recepient,
            'namaSender'=>$sender->nama_user,
            'namaRecepient'=>$recepient->nama_user
        ]);
    }

    public function sendChat(Request $request){
        $chatDetail=new chat;
        $chatDetail->id_chatroom=$request->idChatroom;
        $chatDetail->id_user=Session::get('userId');
        $chatDetail->chat=$request->message;
        $chatDetail->save();
        if($chatDetail){
            return redirect("user/loadDetailChat/$request->idChatroom")->with('success','Chat Berhasil Di Buat');
        }else{
            return redirect("user/loadDetailChat/$request->idChatroom")->with('error','Chat Gagal Di Buat');
        }
    }
    public function loadListSale(){
        $listSale=sale::all();
        return view('listSaleUser',['listSale'=>$listSale]);
    }
    public function loadPageSale($id_kategori){
        $barangSale=barang::where('id_kategori',$id_kategori)->paginate(6);
        return view('pageSaleUser',['listBarangSale'=>$barangSale]);
    }
}





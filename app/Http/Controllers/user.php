<?php

namespace App\Http\Controllers;

use App\merchant as AppMerchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\merchant;
use App\Models\users;
use App\Models\barang;
use App\Models\horder;
use App\Models\alamatpengiriman;
use App\Models\dorder;
use App\Models\chat;
use App\Models\chatroom;
use App\Models\kodeverifikasi;
use App\Models\voucher;
use App\Models\kategoribarang;
use App\Models\reviewmerchant;
use App\Models\sale;
use App\Models\statusorder;
use App\Models\wishlist;
use App\Models\notifikasi;
use App\Models\report;
use Illuminate\Support\Carbon;
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
        $jumlahwishlist=wishlist::where("id_user",$userLogin)->join('barang', 'wishlist.id_barang', '=', 'barang.id_barang')->count();

        //dd($listwishlist);
        return view('wishlist',[
            "wishlist"=>$listwishlist,"jumlahwishlist"=>$jumlahwishlist
        ]);
    }

    public function loadtoko($id){
        $idMerchant=merchant::where('id_merchant',$id)->first();
        //dd($idMerchant);
        $countReview = reviewmerchant::where('id_merchant', $idMerchant->id_merchant)->count();
        $Review =reviewmerchant::where('id_merchant', $idMerchant->id_merchant)->get();
        $jumlahReview = 0;
        foreach ($Review as $key => $value) {
            $jumlahReview = $jumlahReview + $value->score;
        }
        $ratarata = $jumlahReview / $countReview;
        //dd($ratarata);
        $idMerchant=merchant::where('id_merchant',$id)->first();
        $idMerchant->rating_merchant = $ratarata;
        $idMerchant->save();
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
                        Session::put('MerchantId',0);
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
            Session::put("userId","admin");
            Session::put("isAdmin",true);
            return redirect('admin/home');
        }

    }
    public function loadListVoucher(){
        $listVoucher=voucher::all();
        $count = $listVoucher->count();
        $kategori= [];
        for ($i=0; $i < $count; $i++) { 
            $kategori[] = kategoribarang::where('id_kategori', $listVoucher[$i]->id_kategori)->first()->nama_kategori;
        }
        return view('listVoucherUser',['listVoucher'=>$listVoucher, 'kategori'=>$kategori]);
    }
    public function home(Request $req){
        if (Session::has("userId")) {
            $userLogin=Session::get("userId");
            if($req->session()->get('isMerchant')===false){
                $dataBarang=barang::paginate(6);
            }else{
                $dataMechant=merchant::where("id_user",$req->session()->get("userId"))->first();
                $dataBarang=barang::where("id_merchant","!=",$dataMechant->id_merchant)->paginate(6);
            }
            $dataCategori= kategoribarang::all();
            $dataNotifikasi = notifikasi::where('id_user',$userLogin)->where('status','unread')->get();
            return view("home2",['dataBarang'=>$dataBarang,'dataKategori'=>$dataCategori,'dataNotifikasi'=>$dataNotifikasi]);
        }
        else {
            $dataBarang=barang::paginate(6);
            $dataCategori= kategoribarang::all();
            return view("home2",['dataBarang'=>$dataBarang,'dataKategori'=>$dataCategori]);
        }
    }
    public function home2(Request $req){
        
    }


    public function regisMerchant(){
        return view('registerMerchant');
    }

    public function prosesLogout(){
        Session::forget('userId');
        Session::forget('remember');
        Session::forget('isMerchant');
        Session::forget('isAdmin');
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
        $iduser = merchant::find($idMerchant);
        $iduser = $iduser->id_user;
        $dataChatRoom = chatroom::where('id_sender',Session::get('userId'))->where('id_recepient',$iduser)->orWhere('id_sender',$iduser)->where('id_recepient',Session::get('userId'))->first();
        if ($dataChatRoom != null) {
            return redirect("user/loadDetailChat/$dataChatRoom->id_chatroom");
        }
        $makeChatroom=new chatroom;
        $makeChatroom->id_sender=Session::get('userId');
        $makeChatroom->id_recepient=$iduser;
        $makeChatroom->save();
        if($makeChatroom){
            $id_chatroom=chatroom::where('id_sender',Session::get('userId'))->where('id_recepient',$iduser)->first();
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

        $chatRoom = chatroom::find($request->idChatroom);
        $chatRoom->last_message =$request->message;
        $chatRoom->save();

        if($chatDetail){
            return redirect("user/loadDetailChat/$request->idChatroom")->with('success','Chat Berhasil Di Buat');
        }else{
            return redirect("user/loadDetailChat/$request->idChatroom")->with('error','Chat Gagal Di Buat');
        }
    }
    public function loadListSale(){
        $listSale=sale::all();
        $kategori=kategoribarang::all();
        return view('listSaleUser',['listSale'=>$listSale,"kategori"=>$kategori]);
    }
    public function loadPageSale($id_kategori){
        $barangSale=barang::where('id_kategori',$id_kategori)->paginate(6);
        return view('pageSaleUser',['listBarangSale'=>$barangSale,"id_kategori"=>$id_kategori]);
    }
    public function checkOut(Request $request) {
        $userLogin=Session::get("userId");
        $user = users::find($userLogin)->nama_user;
        $dataCart = Session::get("cart_$userLogin");
        $jumlahtotal = 0;
        foreach ($dataCart as $key => $value) {
            $jumlahtotal = $jumlahtotal + ($value["jumlah"] * $value["harga"] + 20000 * $value['jumlah']);
        }
        DB::beginTransaction();
        $alamat = alamatpengiriman::find($request->alamat);
        $Horder = new horder;
        $Horder->id_alamat = $request->alamat;
        $Horder->alamat = $alamat->alamat;
        $Horder->id_user = Session::get("userId");
        $Horder->nama_user = $user;
        $Horder->jumlah_total = $jumlahtotal;
        $Horder->status = "belum dibayar";
        $Horder->save();
        $notifikasipembeli = new notifikasi;
        $notifikasipembeli->id_user = $userLogin;
        $notifikasipembeli->isi = "Ada pembelian baru, segera lakukan pembayaran";
        $notifikasipembeli->status = "unread";
        $notifikasipembeli->save();
        $lastid = $Horder->id_horder;
        if($Horder){
            foreach ($dataCart as $key => $value) {
                $barang = barang::find($value["idBarang"]);
                $namamerchant = merchant::find($value["idMerchant"])->nama_merchant;
                $Dorder = new dorder;
                $Dorder->id_horder = $lastid;
                $Dorder->id_merchant = $value["idMerchant"];
                $Dorder->nama_merchant = $namamerchant;
                //$Dorder->id_voucher = null;
                $Dorder->id_barang = $value["idBarang"];
                $Dorder->nama_barang = $barang->nama_barang;
                $Dorder->jumlah_barang = $value["jumlah"];
                $Dorder->harga_barang = $value['harga'];
                $Dorder->jumlah_total = $value["jumlah"] * $value["harga"] + 20000 *  $value['jumlah'];
                $Dorder->status = "belum dibayar";
                $Dorder->save();
                $statusOrder = new statusorder;
                $statusOrder->id_dorder = $Dorder->id_dorder;
                $statusOrder->status = "belum dibayar";
                $statusOrder->save();
                $iduserMerchant = merchant::find($value["idMerchant"])->id_user;
                $notifikasipenjual = new notifikasi;
                $notifikasipenjual->id_user = $iduserMerchant;
                $notifikasipenjual->isi = "Ada penjualan baru";
                $notifikasipenjual->status = "unread";
                $notifikasipenjual->save();
            }
            DB::commit();
            Session::forget("cart_$userLogin");
            return $this->home($request);
        }else{
            DB::rollBack();
            return redirect()->back()->with('error','Gagal checkout');
        }
        //return view('checkOut',['dataCart'=>$dataCart]);
    }
    public function alamat() {
        $iduser = Session::get("userId");
        $alamat = alamatpengiriman::where('id_user', $iduser)->get();
        return view('alamat',['alamat'=>$alamat]);
    }
    public function tambahAlamat(Request $request) {
        $validateData = $request->validate(
            [
                'namapenerima' => 'required',
                'alamat'=>'required',
                'telepon'=>'required',
            ],
            [
                "namapenerima.required" =>"username tidak boleh kosong",
                "alamat.required" => "alamat tidak boleh kosong",
                "telepon.required" =>"telepon tidak boleh kosong",
            ]
        );
        $iduser = Session::get("userId");
        $alamat = new alamatpengiriman;
        $alamat->id_user = $iduser;
        $alamat->alamat = $request->alamat;
        $alamat->nama_penerima = $request->namapenerima;
        $alamat->telepon = $request->telepon;
        $alamat->save();

        return $this->alamat();
    }
    public function pembelian() {
        $iduser = Session::get("userId");
        $horder = horder::where('id_user', $iduser)->get();
        //$dorder = $horder->dorders()->get();
        return view('pembelian',['horder'=>$horder]);
    }
    public function detailPembelian($idhorder) {
        $dorder = dorder::where('id_horder', $idhorder)->get();
        $horder = horder::find($idhorder);
        $horder = $horder->status;
        $count = count($dorder);
        $databarang = [];
        $total = 0;
        for ($i=0; $i < $count; $i++) {
            $databarang[] = Barang::where('id_barang',$dorder[$i]->id_barang)->first();
            $total = $total + $dorder[$i]->jumlah_total;
        }
        return view("detailPembelian", ['dorder'=>$dorder, 'barang'=>$databarang, 'id_horder'=> $idhorder, 'status'=>$horder, 'total'=>$total]);
    }
    public function bayar(Request $request, $idhorder) {
        $validateData = $request->validate(
            [
                'gambar' => 'required',
            ],
            [
                "gambar.required" =>"Bukti tidak boleh kosong",
            ]
        );
        $horder = horder::find($idhorder);
        $nama = $horder->id_horder.".".$request->file("gambar")->getClientOriginalExtension();
        $request->file("gambar")->storeAs("images_bukti", $nama, "public");
        $horder->bukti_pembayaran = $nama;
        $horder->status = "sudah dibayar";
        $horder->save();

        dorder::where('id_horder', $idhorder)
          ->update(['status' => 'sudah dibayar']);

        $dorder = dorder::where('id_horder', $idhorder)->get();
        foreach ($dorder as $key => $value) {
            $statusorder = new statusorder;
            $statusorder->id_dorder = $value->id_dorder;
            $statusorder->status = "sudah dibayar";
            $statusorder->save();
        }
        return redirect()->back();
    }
    public function penjualan() {
        $merchant = merchant::where('id_user', Session::get('userId'))->first();
        $merchant = $merchant->id_merchant;
        $dorder = dorder::where('id_merchant', $merchant)->get();
        //dd($dorder);
        $count = count($dorder);
        $datahorder = [];
        for ($i=0; $i < $count; $i++) {
            $datahorder[] = horder::where('id_horder',$dorder[$i]->id_horder)->first();
        }
        return view('penjualan', ['dorder'=>$dorder, 'datahorder'=>$datahorder]);
    }
    public function kirim(Request $request,$iddorder) {
        // $validateData = $request->validate(
        //     [
        //         'nomor_resi' => 'required',
        //     ],
        //     [
        //         "nomor_resi.required" =>"Resi Tidak Boleh Kosong",
        //     ]
        // );
        $dorder = dorder::find($iddorder);
        $dorder->status = "sudah dikirim";
        // $dorder->resi_pengiriman = $request->nomor_resi;
        $dorder->save();

        $status = new statusorder;
        $status->id_dorder = $iddorder;
        $status->status = "sudah dikirim";
        $status->save();

        $idpembeli = horder::where('id_horder',$dorder->id_horder)->first()->id_user;
        $notifikasi = new notifikasi;
        $notifikasi->id_user = $idpembeli;
        $notifikasi->isi = "Pesanan telah dikirim oleh penjual";

        return redirect()->back();
    }
    public function terima($iddorder) {
        $dorder = dorder::find($iddorder);
        $dorder->status = "selesai";
        $dorder->save();

        $merchant = merchant::find($dorder->id_merchant);
        $user = users::find($merchant->id_user);
        $user->saldo = $user->saldo + $dorder->jumlah_total;
        $user->save();

        $status = new statusorder;
        $status->id_dorder = $iddorder;
        $status->status = "selesai";
        $status->save();

        $notifikasi = new notifikasi;
        $notifikasi->id_user = $user->id;
        $notifikasi->isi = "Penjualan Selesai";
        $notifikasi->status = "unread";
        $notifikasi->save();

        return redirect()->back();
    }
    public function review(Request $request, $idmerchant, $iddorder) {
        $userLogin=Session::get("userId");

        $score = $request->score;
        $isi = $request->isi;
        $review = new reviewmerchant;
        $review->id_dorder = $iddorder;
        $review->id_user = $userLogin;
        $review->id_merchant = $idmerchant;
        $review->score = $score;
        $review->isi_review = $isi;
        $review->save();

        $dorder = dorder::find($iddorder);
        $dorder->status = "reviewed";
        $dorder->save();

        $status = new statusorder;
        $status->id_dorder = $iddorder;
        $status->status = "reviewed";
        $status->save();

        return redirect()->back();
    }
    public function reviewMerchant($idmerchant) {
        $review = reviewmerchant::where('id_merchant', $idmerchant)->get();

        $count = count($review);
        $dataUser = [];
        for ($i=0; $i < $count; $i++) {
            $dataUser[] = users::where('id',$review[$i]->id_user)->first();
        }

        return view("reviewMerchant",['dataReview'=> $review, 'dataUser'=>$dataUser]);
    }

    public function filterPembelian(Request $request){
        $strToDateAwal= strtotime($request->filterTanggalAwal);
        $strToDateAkhir= strtotime($request->filterTanggalAkhir);
        $dateAwal=date('Y-m-d 00:00:00',$strToDateAwal);
        $dateAkhir=date('Y-m-d 00:00:00',$strToDateAkhir);
        $filterResult=horder::whereBetween('created_at',[$dateAwal, $dateAkhir])->where('id_user',Session::get('userId'))->get();

        return view('pembelian',[
            "horder"=>$filterResult
            ]);
    }
    public function filterPenjualan(Request $request){
        $strToDateAwal= strtotime($request->filterTanggalAwal);
        $strToDateAkhir= strtotime($request->filterTanggalAkhir);
        $dateAwal=date('Y-m-d 00:00:00',$strToDateAwal);
        $dateAkhir=date('Y-m-d 00:00:00',$strToDateAkhir);
        $merchant = merchant::where('id_user', Session::get('userId'))->first();
        $merchant = $merchant->id_merchant;
        $filterResult=dorder::whereBetween('created_at',[$dateAwal, $dateAkhir])->where('id_merchant', $merchant)->get();
        $count = count($filterResult);
        $datahorder = [];
        for ($i=0; $i < $count; $i++) {
            $datahorder[] = horder::where('id_horder',$filterResult[$i]->id_horder)->first();
        }
        return view('penjualan',[
            "dorder"=>$filterResult, 'datahorder'=>$datahorder
        ]);
    }

    public function searchChat(Request $request){
        $idUserDiCari=users::where('nama_user',$request->KeySearchNamaUser)->first();

        $hasilCari=chatroom::whereRaw('id_sender = ? AND id_recepient = ?',array(Session::get('userId'),$idUserDiCari->id))->
        orWhereRaw("id_recepient = ? AND id_sender = ?",array(Session::get('userId'),$idUserDiCari->id))->get();

        $count = count($hasilCari);
        $datanama = [];

        for ($i=0; $i < $count; $i++) {
            if(users::find($hasilCari[$i]->id_sender)->id == Session::get('userId')) {
                $dataNama[] = users::find($hasilCari[$i]->id_recepient);
            }
            else {
                $dataNama[] = users::find($hasilCari[$i]->id_sender);
            }
        }
        //$dataChatroom=json_decode(json_encode($dataChatroom),true);
        if (isset($dataNama)) {
            $dataNama=json_decode(json_encode($dataNama),true);
            return view('chatroom',['headerChat'=>$hasilCari, 'nama'=>$dataNama]);
        }
        else {
            return view('chatroom',['headerChat'=>$hasilCari]);
        }
    }
    public function useVoucher(Request $req) {
        $userLogin=Session::get("userId");
        $dataCart = Session::get("cart_$userLogin");

        $kodeVoucher1 = $req->codevoucher;
        $kodeVoucher = str_replace(' ', '', $kodeVoucher1);
        $voucher = voucher::where('kode_voucher',$kodeVoucher)->first();
        if ($voucher) {
            //dd($dataCart);
            $cek = false;
            foreach ($dataCart as $key => $value) {
                $idKategori = barang::where('id_barang', $value['idBarang'])->first()->id_kategori;
                $curdate=strtotime(Carbon::now()->format('Y-m-d'));
                $mydate=strtotime($voucher->masa_berlaku);
                if ($idKategori == $voucher->id_kategori) {
                    if ($mydate > $curdate) {
                        $dataCart[$key]['harga'] = $value['harga'] - $voucher->diskon;
                        $cek = true;
                    }
                }
            }
            if ($cek) {
                Session::put("cart_$userLogin",$dataCart);
                return redirect()->back()->with('success','Kode Voucher Ditambahkan');
            }
            else {
                return redirect()->back()->with('error','Kode Voucher Tidak Berlaku');
            }       
            
        }
        else {
            return redirect()->back()->with('error','Kode Voucher tidak ditemukan');
        }
    }
    public function markAsRead($idnotifikasi) {
        $notifikasi = notifikasi::find($idnotifikasi);
        $notifikasi->status = "read";
        $notifikasi->save();

        return redirect("/user/home");
    }
    public function report($idmerchant, $iddorder, Request $req) {
        $validateData = $req->validate(
            [
                'gambar' => 'required',
            ],
            [
                "gambar.required" =>"Bukti tidak boleh kosong",
            ]
        );
        $dorder = dorder::where('id_dorder',$iddorder)->first();
        
        $report = new report;
        $report->id_horder = $dorder->id_horder;
        $report->id_dorder = $iddorder;
        $report->id_merchant = $idmerchant;
        $report->isi_report = $req->masalah;
        $report->bukti_report = "";
        $report->save();
        $nama = $report->id_report.".".$req->file("gambar")->getClientOriginalExtension();
        $req->file("gambar")->storeAs("images_bukti_report", $nama, "public");
        $report->bukti_report = $nama;
        $report->save();

        $dorder->status = "reported";
        $dorder->save();

        $status = new statusorder;
        $status->id_dorder = $iddorder;
        $status->status = "reported";
        $status->save();

        return redirect()->back();
    }
    public function reportPenjualan() {
        $userLogin=Session::get("userId");
        $dataMonth = [];
        for ($i=0; $i < 12; $i++) { 
            $dataMonth[] = DB::table('dorder')
                    ->join('merchant', 'dorder.id_merchant', '=', 'merchant.id_merchant')
                    ->where('merchant.id_user', $userLogin)
                    ->whereYear('dorder.created_at', 2020)
                    ->whereMonth('dorder.created_at', $i+1)
                    ->count();
        }
        $dataMonth2 = [];
        for ($i=0; $i < 12; $i++) {
            
            $data = DB::table('dorder')
                    ->join('merchant', 'dorder.id_merchant', '=', 'merchant.id_merchant')
                    ->where('merchant.id_user', $userLogin)
                    ->whereYear('dorder.created_at', 2020)
                    ->whereMonth('dorder.created_at', $i+1)
                    ->get();
            $jumlahtotal = 0;   
            foreach ($data as $key => $value) {
                $jumlahtotal = $jumlahtotal + $value->jumlah_total;
            }
            $dataMonth2[] = $jumlahtotal;
        }
        return view("reportPenjualan")->with(compact('dataMonth','dataMonth2'));
    }
    public function prosesReportPenjualan(Request $req) {
        $tahun = $req->tahun;
        $userLogin=Session::get("userId");
        $dataMonth = [];
        for ($i=0; $i < 12; $i++) { 
            $dataMonth[] = DB::table('dorder')
                    ->join('merchant', 'dorder.id_merchant', '=', 'merchant.id_merchant')
                    ->where('merchant.id_user', $userLogin)
                    ->whereYear('dorder.created_at', $tahun)
                    ->whereMonth('dorder.created_at', $i+1)
                    ->count();
        }
        $dataMonth2 = [];
        for ($i=0; $i < 12; $i++) {
            
            $data = DB::table('dorder')
                    ->join('merchant', 'dorder.id_merchant', '=', 'merchant.id_merchant')
                    ->where('merchant.id_user', $userLogin)
                    ->whereYear('dorder.created_at', $tahun)
                    ->whereMonth('dorder.created_at', $i+1)
                    ->get();
            $jumlahtotal = 0;   
            foreach ($data as $key => $value) {
                $jumlahtotal = $jumlahtotal + $value->jumlah_total;
            }
            $dataMonth2[] = $jumlahtotal;
        }
        return view("reportPenjualan")->with(compact('dataMonth','dataMonth2'));
    }
}





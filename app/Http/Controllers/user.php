<?php

namespace App\Http\Controllers;

use App\merchant as AppMerchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\merchant;
use App\Models\users;
use App\Models\barang;
use Illuminate\Support\Facades\Hash;

class user extends Controller
{
    public function register(Request $req){

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
        $password = $validateData["password"];

        $data = users::where('email',$email)->count();
        if($data<=0){
            $insertNewUsers= new users;
            $insertNewUsers->email= $email;
            $insertNewUsers->password=password_hash($password, \PASSWORD_DEFAULT);;
            $insertNewUsers->nama_user=$nama;
            $insertNewUsers->saldo=0;
            $insertNewUsers->save();

            if($insertNewUsers){
                return redirect('/home');
            }else{
                return redirect()->back()->with('error','Gagal Mendaftar, Silahkan Cek Kembali Form Pendaftaran');
            }
        }
        else{
            return redirect()->back()->with('error','Email Sudah Terdaftar, Silahkan Gunakan Email Lainnya');
        }


    }
    public function login(Request $req)
    {
        $email = $req->email;
        $password = $req->password;
        $data = DB::table('users')->where('email',$email)->count();
        if($data>0){
            $dataUser = DB::table('users')->where('email',$email)->get();
            $dataUser=json_decode(json_encode($dataUser),true);
            if(Hash::check($password, $dataUser[0]['password'])){
                Session::put("active",$email);
                if($req->remember==true){
                    Session::put("remember",$email);
                }
                Session::put("userId",$dataUser[0]['id']);
                return redirect('home');
            }else{
                return redirect()->back()->with('error','Email Atau Password Salah, Silahkan Cek Kembali Email dan Password Anda');
            }
        }
        else{
            return redirect()->back()->with('error','User Tidak Ditemukan, Silahkan Cek Kembali Email dan Password Anda');
        }
    }

    public function home(){
        $dataBarang=barang::all();
        return view("home2",['dataBarang'=>$dataBarang]);
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
}



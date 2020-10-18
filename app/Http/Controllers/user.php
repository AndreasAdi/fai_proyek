<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

        $data = DB::table('users')->where('email',$email)->count();
        if($data<=0){
            DB::table('users')->insertGetId(
                [
                    'nama_user'=> $nama,
                    'email'=> $email,
                    'password'=>$password,
                ]
            );
            $success = true;
        }
        else{
            $success =false;
        }

        return(view("login"));
    }
    public function login(Request $req)
    {
        $email = $req->email;
        $password = $req->password;
        $data = DB::table('users')->where('email',$email)->where('password',$password)->count();

        if($data>0){
            Session::put("active",$email);
            if($req->remember==true){
                Session::put("remember",$email);
            }
            return redirect('home');

        }
        else{
            return redirect('/');
        }


    }

    public function home(){
        return view("home");
    }
}



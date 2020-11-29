<?php

namespace App\Http\Controllers;

use App\Models\dorder;
use App\Models\horder;
use App\Models\sale;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\kategoribarang;
use App\Models\merchant;
use App\Models\notifikasi;
use App\Models\report;
use App\Models\statusorder;

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
        $kategori=kategoribarang::all();
        return view('listSaleAdmin',['listSale'=>$listSale,"kategori"=>$kategori]);
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
    public function konfirmasi() {
        $horder = horder::where('status', 'sudah dibayar')->get();

        return view('konfirmasiAdmin', ['horder'=> $horder]);
    }
    public function konfirmasiOrder($idhorder) {
        $horder = horder::find($idhorder);
        $horder->status = "sudah dikonfirmasi";
        $horder->save();

        $notifikasi = new notifikasi;
        $notifikasi->id_user = $horder->id_user;
        $notifikasi->isi = "Pembayaran telah dikonfirmasi";
        $notifikasi->status = "unread";
        $notifikasi->save();



        dorder::where('id_horder', $idhorder)
          ->update(['status' => 'sudah dikonfirmasi']);

        $dorder = dorder::where('id_horder', $idhorder)->get();
        foreach ($dorder as $key => $value) {
            $statusorder = new statusorder;
            $statusorder->id_dorder = $value->id_dorder;
            $statusorder->status = "sudah dikonfirmasi";
            $statusorder->save();

            $idpenjual = merchant::where('id_merchant', $value['id_merchant'])->first()->id_user;
            $notifikasi = new notifikasi;
            $notifikasi->id_user = $idpenjual;
            $notifikasi->isi = "Penjualan telah dibayar dan dikonfirmasi, segera kirim pesanan";
            $notifikasi->status = "unread";
            $notifikasi->save();
        }

        return redirect()->back();
    }
    public function konfirmasiReport() {
        $report = report::where('status', 'new')->get();
        $count = count($report);
        $datamerchant = [];
        for ($i=0; $i < $count; $i++) {
            $datamerchant[] = merchant::where('id_merchant',$report[$i]->id_merchant)->first();
        }
        return view('konfirmasiReportAdmin', ['report'=> $report, 'datamerchant'=> $datamerchant]);
    }
    public function konfirmReport($idreport, $idhorder) {
        $horder = horder::find($idhorder);

        $report = report::find($idreport);
        $report->status = "confirmed";
        $report->save();

        $notifikasi = new notifikasi;
        $notifikasi->id_user = $horder->id_user;
        $notifikasi->isi = "Report pesanan sudah dikonfirmasi";
        $notifikasi->status = "unread";
        $notifikasi->save();



        dorder::where('id_horder', $idhorder)
          ->update(['status' => 'report sudah dikonfirmasi']);

        $dorder = dorder::where('id_horder', $idhorder)->get();
        foreach ($dorder as $key => $value) {
            $statusorder = new statusorder;
            $statusorder->id_dorder = $value->id_dorder;
            $statusorder->status = "report sudah dikonfirmasi";
            $statusorder->save();

            $idpenjual = merchant::where('id_merchant', $value['id_merchant'])->first()->id_user;
            $notifikasi = new notifikasi;
            $notifikasi->id_user = $idpenjual;
            $notifikasi->isi = "Report penjualan sudah dikonfirmasi";
            $notifikasi->status = "unread";
            $notifikasi->save();
        }

        return redirect()->back();
    }
    public function rejectReport($idreport, $idhorder) {
        $horder = horder::find($idhorder);

        $report = report::find($idreport);
        $report->status = "rejected";
        $report->save();

        $notifikasi = new notifikasi;
        $notifikasi->id_user = $horder->id_user;
        $notifikasi->isi = "Report pesanan rejected";
        $notifikasi->status = "unread";
        $notifikasi->save();


        dorder::where('id_horder', $idhorder)
          ->update(['status' => 'report rejected']);

        $dorder = dorder::where('id_horder', $idhorder)->get();
        foreach ($dorder as $key => $value) {
            $statusorder = new statusorder;
            $statusorder->id_dorder = $value->id_dorder;
            $statusorder->status = "report rejected";
            $statusorder->save();

            $idpenjual = merchant::where('id_merchant', $value['id_merchant'])->first()->id_user;
            $notifikasi = new notifikasi;
            $notifikasi->id_user = $idpenjual;
            $notifikasi->isi = "Report penjualan rejected";
            $notifikasi->status = "unread";
            $notifikasi->save();
        }

        return redirect()->back();
    }
}

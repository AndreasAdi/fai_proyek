@extends('template')
@section('judul')
Tambah Voucher
@endsection
@section('isi')
@include('alert')

<div class="container mt-5 col-6">
    <h1 class="text-success">Tambah Voucher</h1>
    <form action="{{url('voucher/TambahVoucher')}}" method="POST" enctype="multipart/form-data">
        @method('POST')
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Voucher</label>
            <input class="form-control" type="text"  name="namaVoucher" id="">
        </div>

        <div class="mb-3">
            <label class="form-label">Diskon</label>
            <input class="form-control" type="text"  name="diskon" id="">
        </div>

        <div class="mb-3">
            <label class="form-label">Berlaku Sampai Dengan (YYYY/mm/DD)</label>
            <input class="form-control" type="text"  name="MasaBerlaku" id="">
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select class="form-select" name='kategori'>
                <option selected>Select Kategori</option>
                @foreach ($dataKategori as $item)
                    <option value="{{$item['id_kategori']}}">{{$item['nama_kategori']}}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success float-right" type="submit">Tambahkan Voucher</button>
    </form>

</div>

@endsection


@extends('template')
@section('judul')
Tambah Barang
@endsection
@section('isi')
@include('alert')

<div class="container mt-5 col-6">
    <h1>Tambah Barang</h1>
    <form action="{{url('/prosesTambahBarang')}}" method="POST" enctype="multipart/form-data">
        @method('POST')
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input class="form-control" type="text"  name="namaBarang" id="">
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Barang</label>
            <input class="form-control" type="number" name='hargaBarang'>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
        <input class="form-control" type="text" name='stokBarang'>

        </div>

        <div class="mb-3">
            <label class="form-label"> Harga Sale</label>
            <input class="form-control" type="text" name='hargaSale'>
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

        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input class="form-control" type="file" name="gambar" class="form-control">
          </div>

        <button class="btn btn-success float-right" type="submit">Tambahkan Barang</button>
    </form>

</div>
@endsection


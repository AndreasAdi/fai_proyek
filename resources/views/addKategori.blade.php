@extends('template')
@section('judul')
Tambah Kategori
@endsection
@section('isi')
@include('alert')

<div class="container mt-5 col-6">
    <h1 class="text-success">Tambah Kategori</h1>
    <form action="{{url('admin/TambahKategori')}}" method="POST" enctype="multipart/form-data">
        @method('POST')
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input class="form-control" type="text"  name="nama" id="">
        </div>

        <button class="btn btn-success float-right" type="submit">Tambahkan Kategori</button>
    </form>

</div>

@endsection


@extends('template')
@section('judul')
Tambah Sale
@endsection
@section('isi')
@include('alert')

<div class="container mt-5 col-6">
    <h1 class="text-success">Tambah Sale</h1>
    <form action="{{url('sale/TambahSale')}}" method="POST">
        @method('POST')
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Sale</label>
            <input class="form-control" type="text"  name="nama_sales" id="">
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select class="form-select" name='id_kategori'>
                <option selected>Select Kategori</option>
                @foreach ($dataKategori as $item)
                    <option value="{{$item['id_kategori']}}">{{$item['nama_kategori']}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Berlaku Sampai Dengan (YYYY/mm/DD)</label>
            <input class="form-control" type="text"  name="tanggal_habis" id="">
        </div>

        <button class="btn btn-success float-right" type="submit">Tambahkan Sale</button>
    </form>

</div>

@endsection


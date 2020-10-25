@extends('template')
@section('judul')
home
@endsection
@section('isi')

<div class="container mt-5">

    <form class="d-flex mx-auto mb-5 col-6">
        <input class="form-control mr-2 align-middle" type="search" placeholder="Cari Barang" aria-label="Search">
        <button class="btn btn-success" type="submit">Cari</button>
      </form>

    <div class="card" style="width: 18rem;">
        <img src="laptop.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <p class="card-text">TOTOLINK N200RE 300Mbps Mini Wireless Router TOTOLINK N200 RE Resmi</p>
          <a href="#" class="btn btn-block btn-success">Lihat Barang</a>
        </div>
      </div>
</div>
@endsection

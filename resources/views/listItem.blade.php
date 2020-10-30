@extends('template')
@section('isi')

{{-- <div class="container mt-5">
    <h1>Your Item</h1>
    @include('alert')
    <div class="d-flex flex-row ">
        <table class="table table-dark">
            <thead>
                <th>
                    Nama
                </th>
                <th>
                    Stok
                </th>
                <th>
                    Harga
                </th>
                <th>
                    Status
                </th>
                <th>
                    Action
                </th>
            </thead>
            <tbody>
                @if (isset($dataItem))
                    @foreach ($dataItem as $item)
                        <tr>
                            <td>
                                {{$item['nama_barang']}}
                            </td>
                            <td>
                                {{$item['stok']}}
                            </td>
                            <td>
                                Rp. {{number_format($item['harga']),2,",","."}}
                            </td>
                            <td>
                                @if (is_null($item['deleted_at']))
                                    Aktif
                                @else
                                    Non-Aktif
                                @endif
                            </td>
                            <td>
                                <a href="{{url("barang/editBarang/$item[id_barang]")}}" class="btn btn-warning">Edit</a>
                                @if (is_null($item['deleted_at']))
                                    <form action="{{url("barang/NonAktifBarang/$item[id_barang]")}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class='btn btn-danger'>Non-Aktifkan Barang</button>
                                    </form>
                                @else
                                    <form action="{{url("barang/aktifkanBarang/$item[id_barang]")}}" method="POST">
                                        @method('PATCH')
                                        @csrf
                                        <button class='btn btn-success'>Aktifkan Barang</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <h2>Anda Tidak Memiliki Barang Terdaftar</h2>
                @endif
            </tbody>
        </table><br>
    </div>
</div> --}}

<div class='d-flex justify-content-center  flex-wrap'>
    @foreach ($dataItem as $item)
        <div class="card m-3 shadow" style="width: 18rem;">
        <img style="height: 200px;object-fit: scale-down;"  src="{{asset("/storage/images/".$item->gambar_barang)}}" class="card-img-top" alt="...">
            <div class="card-body">
            <p class="card-text text-truncate">{{$item->nama_barang}}</p>
            <p class="card-text"><b>Rp. {{number_format($item->harga),2,",","."}}</b></p>
            <a href="{{url("barang/detailBarang/$item->id_barang")}}" class="btn btn-block btn-success">Lihat Barang</a>
            </div>
        </div>
    @endforeach
</div>

@endsection

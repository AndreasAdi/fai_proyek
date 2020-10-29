@extends('template')
@section('isi')

<div class="container mt-5">
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
</div>

@endsection

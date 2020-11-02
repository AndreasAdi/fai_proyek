@extends('template')
@section('isi')

<div class="container mt-5  text-success">
    <h1>Your Voucher</h1>
    <div class="d-flex flex-row">
        <table class="table table-striped">
            <thead>
                <th>
                    Nama
                </th>
                <th>
                    Berlaku Sampai Dengan
                </th>
                <th>
                    Action
                </th>
                <th>
                    Deskripsi
                </th>
            </thead>
            <tbody>
                @if (isset($listSale))
                    @foreach ($listSale as $item)
                        <tr>
                            <td>
                                {{$item->nama_sales}}
                            </td>
                            <td>
                                {{$item->tanggal_habis}}
                            </td>
                            <td>
                                <a href="{{url("user/loadPageSale/$item->id_kategori")}}" class="btn btn-primary">Lihat Sale</a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-success">Lihat Deskripsi</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <h2>Tidak Ada Sale</h2>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table><br>
    </div>
</div>

@endsection

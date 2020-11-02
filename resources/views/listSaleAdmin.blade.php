@extends('template')
@section('isi')

<div class="container mt-5  text-success">
    <h1>List Sale</h1>
    @include('alert')
    <div class="d-flex flex-row">
        <table class="table table-striped">
            <thead>
                <th>
                    Nama
                </th>
                <th>
                    Id Sale
                </th>
                <th>
                    Berlaku Sampai Dengan
                </th>
                <th>
                    Kategori
                </th>
                <th>
                    Status
                </th>
                <th>
                    Action
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
                                {{$item->id_sales}}
                            </td>

                            <td>
                                {{$item->tanggal_habis}}
                            </td>
                            <td>
                                {{$item->id_kategori}}
                            </td>
                            <td>
                                @if ($item->deleted_at==null)
                                   <b><p class="text-success">Aktif</p></b>
                                @else
                                   <b><p class='text-danger'>Tidak Aktif</p></b>
                                @endif
                            </td>
                            <td>
                                @if ($item->deleted_at==null)
                                    <form action="{{url("sale/NonAktifkanSale/$item->id_sales")}}" method='POST'>
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger">Non-Aktif</button>
                                    </form>
                                @else
                                    <form action="{{url("sale/AktifkanSale/$item->id_sales")}}" method='POST'>
                                        @method('PATCH')
                                        @csrf
                                        <button class="btn btn-success">Aktif</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <h2>Tidak Ada Voucher</h2>
                        </td>
                    </tr>

                @endif
            </tbody>
        </table><br>
    </div>
</div>

@endsection

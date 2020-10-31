@extends('template')
@section('isi')

<div class="container mt-5  text-success">
    <h1>List Voucher</h1>
    @include('alert')
    <div class="d-flex flex-row">
        <table class="table table-striped">
            <thead>
                <th>
                    Nama
                </th>
                <th>
                    Id Voucher
                </th>
                <th>
                    Diskon
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
                @if (isset($listVoucher))
                    @foreach ($listVoucher as $item)
                        <tr>
                            <td>
                                {{$item->nama_voucher}}
                            </td>
                            <td>
                                {{$item->id_voucher}}
                            </td>
                            <td>
                                Rp. {{number_format($item->diskon),2,",","."}}
                            </td>
                            <td>
                                {{$item->masa_berlaku}}
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
                                    <form action="{{url("voucher/NonAktifkanVoucher/$item->id_voucher")}}" method='POST'>
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger">Non-Aktif</button>
                                    </form>
                                @else
                                    <form action="{{url("voucher/AktifkanVoucher/$item->id_voucher")}}" method='POST'>
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

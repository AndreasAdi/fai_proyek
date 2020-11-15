@extends('template')
@section('isi')
<div class="container mt-5  text-success">
    <h1>Daftar Pembelian</h1>
    <div class="d-flex flex-row">
        <table class="table table-striped">
            <thead>
                <th>
                    Id Order
                </th>
                <th>
                    Alamat
                </th>
                <th>
                    Total Harga
                </th>
                <th>
                    Tanggal Pemesanan
                </th>
                <th>
                    Status Pembayaran
                </th>
                <th>
                    Action
                </th>
            </thead>
            <tbody>
                @if (isset($horder))
                    @foreach ($horder as $item)
                        
                        <tr>
                            <td>
                                {{$item->id_horder}}
                            </td>
                            <td>
                                {{$item->alamat}}
                            </td>
                            <td>
                                {{$item->jumlah_total}}
                            </td>
                            <td>
                                {{$item->created_at}}
                            </td>
                            <td>
                                {{$item->status}}
                            </td>
                            <td>
                                <form action="pembelian/{{ $item->id_horder }}">
                                    <button type="submit" class='btn btn-success'>Detail</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table><br>
    </div>
</div>
@endsection
@extends('template')
@section('isi')
<div class="container mt-5  text-success">
    <h1>Daftar Pembelian</h1>
    <div class="d-flex flex-row">
        <table class="table table-striped">
            <thead>
                <th>
                    Barang
                </th>
                <th>
                    Merchant
                </th>
                <th>
                    Harga
                </th>
                <th>
                    Jumlah
                </th>
                <th>
                    Total
                </th>
                <th>
                    Status
                </th>
            </thead>
            <tbody>
                @if (isset($dorder))
                    @foreach ($dorder as $item)
                        
                        <tr>
                            <td>
                                {{$item->nama_barang}}
                            </td>
                            <td>
                                {{$item->nama_merchant}}
                            </td>
                            <td>
                                {{$item->harga_barang}}
                            </td>
                            <td>
                                {{$item->jumlah_barang}}
                            </td>
                            <td>
                                {{$item->jumlah_total}}
                            </td>
                            <td>
                                {{$item->status}}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table><br>
    </div>
</div>
@endsection
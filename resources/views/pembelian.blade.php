@extends('template')
@section('isi')
<div class="container mt-5  text-success">
    <h1>Daftar Pembelian</h1>
        <div class="clearfix">
            <form action='{{url("user/filterDaftarPembelian")}}' method="POST">
                @method('POST')
                @csrf
                <div class="input-group mb-3">
                    <input type="date" class="form-control" placeholder="Pick A Date" name='filterTanggal aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-outline-success" type="submit">Filter</button>
                    </div>
                </div>
            </form>
            <a href={{url("user/pembelian")}}><button class="btn btn-success mb-2 form-control">Reset</button></a>
        </div>
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
                                Rp. {{number_format($item->jumlah_total),2,",","."}}
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

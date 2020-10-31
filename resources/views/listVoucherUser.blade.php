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
                    Id Voucher
                </th>
                <th>
                    Diskon
                </th>
                <th>
                    Berlaku Sampai Dengan
                </th>
                <th>
                    Deskripsi
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
                                <a href="#" class="btn btn-success">Lihat Deskripsi</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
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

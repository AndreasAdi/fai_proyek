@extends('template')
@section('judul')
List Voucher
@endsection
@section('isi')

<div class="container mt-5  text-success">
    <h1>Your Voucher</h1>
        <table class="table table-striped" id="table">
            <thead>
                <th>
                    Nama
                </th>
                <th>
                    Kode Voucher
                </th>
                <th>
                    Kategori Barang
                </th>
                <th>
                    Diskon
                </th>
                <th>
                    Berlaku Sampai Dengan
                </th>
            </thead>
            <tbody>
                @if (isset($listVoucher))
                    @foreach ($listVoucher as $key => $item)
                        <tr>
                            <td>
                                {{$item->nama_voucher}}
                            </td>
                            <td>
                                {{$item->kode_voucher}}
                            </td>
                            <td>
                                {{$kategori[$key]}}
                            </td>
                            <td>
                                Rp. {{number_format($item->diskon),2,",","."}}
                            </td>
                            <td>
                                {{$item->masa_berlaku}}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
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

@endsection

@push('js')
<script>
$("#table").dataTable();
</script>
@endpush

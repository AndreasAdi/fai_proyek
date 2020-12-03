@extends('template')
@section('judul')
History Pembelian
@endsection
@section('isi')
@section('style')
.pagination > li > a,
.pagination > li > span {
    color: green;
}

.pagination > .active > a,
.pagination > .active > a:focus,
.pagination > .active > a:hover,
.pagination > .active > span,
.pagination > .active > span:focus,
.pagination > .active > span:hover {
    background-color: #198754;
    border-color: #198754;
}

.page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #198754; //your color
    border-color: #198754; //your color
}
.page-link:hover{
    z-index: 1;
    color: #198754;
    border-color: #198754; //your color
}

@endsection
<div class="container mt-5  text-success">
    <h1>Daftar Pembelian</h1>
        <div class="clearfix">
            <form action='{{url("user/filterDaftarPembelian")}}' method="POST">
                @method('POST')
                @csrf
                <h5>Filter Tanggal (Awal & Akhir)</h5>
                <div class="input-group mb-3">
                    
                    <input type="date" class="form-control" placeholder="Pick A Date" name='filterTanggalAwal' aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <input type="date" class="form-control" placeholder="Pick A Date" name='filterTanggalAkhir' aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-outline-success" type="submit">Filter</button>
                    </div>
                </div>
            </form>
            <a href={{url("user/pembelian")}}><button class="btn btn-success mb-2 form-control">Reset</button></a>
        </div>
 
        <table class="table table-striped" id="table">
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
@endsection

@push('js')
<script>
$("#table").dataTable();
</script>
@endpush



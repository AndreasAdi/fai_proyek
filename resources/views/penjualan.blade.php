@extends('template')
@section('judul')
Penjualan
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
    <h1>Daftar Penjualan</h1>
    @include('alert')
    <div class="clearfix">
        <form action='{{url("user/filterDaftarPenjualan")}}' method="POST">
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
        <a href={{url("user/penjualan")}}><button class="btn btn-success mb-2 form-control">Reset</button></a>
    </div>
    <div class="d-flex flex-row">
        <table class="table table-striped" id="table">
            <thead>
                <th>
                    Nama Pembeli
                </th>
                <th>
                    Nama Barang
                </th>
                <th>
                    Jumlah Barang
                </th>
                <th>
                    Harga Barang
                </th>
                <th>
                    Jumlah Total
                </th>
                <th>
                    Status
                </th>
                <th>
                    Action
                </th>
            </thead>
            <tbody>
                @if (isset($dorder))
                    @foreach ($dorder as $key => $item)

                        <tr>
                            <td>
                                {{$datahorder[$key]->nama_user}}
                            </td>
                            <td>
                                {{$item->nama_barang}}
                            </td>
                            <td>
                                {{$item->jumlah_barang}}
                            </td>
                            <td>
                                Rp. {{number_format($item->harga_barang),2,",","."}}
                            </td>
                            <td>
                                Rp. {{number_format($item->jumlah_total),2,",","."}}
                            </td>
                            <td>
                                {{$item->status}}
                            </td>
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#no{{$item->id_dorder}}">
                                    Detail
                                  </button>

                                  <!-- Modal -->
                                  <div class="modal fade" id="no{{$item->id_dorder}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalCenterTitle">Detail</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <h3>Status Order : </h3>
                                          <p>{{$item->status}}</p>
                                          @if ($item->status == 'sudah dikonfirmasi')
                                            <h3>Kirim Barang</h3>
                                            <form action="{{url("/user/kirim/$item->id_dorder")}}" method="POST">
                                                @csrf
                                                {{-- Nomor Resi : <input class="form-control" type="text" name="nomor_resi" id=""> --}}
                                                <button type="submit" class="btn btn-success">Kirim</button>
                                            </form>
                                          @endif

                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                    </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table><br>
        
    </div>

</div>
@endsection

@push('js')
<script>
$("#table").dataTable();
</script>
@endpush

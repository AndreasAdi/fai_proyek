@extends('template')
@section('judul')
Konfirmasi Pembayaran
@endsection
@section('isi')

<div class="container mt-5  text-success">
    <h1>List Pembayaran</h1>
    @include('alert')

        <table class="table table-striped" id="table">
            <thead>
                <th>
                    Id Horder
                </th>
                <th>
                    Id User
                </th>
                <th>
                    Jumlah Total
                </th>
                <th>
                    Bukti Pembayaran
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
                                {{$item->id_user}}
                            </td>

                            <td>
                               Rp. {{number_format($item->jumlah_total),2,",","."}}
                            </td>
                            <td>
                                <img src="{{asset("/storage/images_bukti/".$item->bukti_pembayaran)}}" width="300px">
                            </td>
                            <td>
                                <form action="{{url("admin/konfirmasi/$item->id_horder")}}" method='GET'>
                                    @csrf
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#no{{$item->id_horder}}">
                                        Konfirmasi
                                      </button>

                                      <!-- Modal -->
                                      <div class="modal fade" id="no{{$item->id_horder}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalCenterTitle">Yakin Konfirmasi?</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              Yakin Konfirmasi?
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-success">Konfirmasi</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                </form>
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

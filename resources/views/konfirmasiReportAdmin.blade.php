@extends('template')
@section('isi')

<div class="container mt-5  text-success">
    <h1>List Report</h1>
    @include('alert')
    <div class="d-flex flex-row">
        <table class="table table-striped">
            <thead>
                <th>
                    Id Horder
                </th>
                <th>
                    Id Dorder
                </th>
                <th>
                    Merchant
                </th>
                <th>
                    Isi Report
                </th>
                <th>
                    Bukti Report
                </th>
                <th>
                    Action
                </th>
            </thead>
            <tbody>
                @if (isset($report))
                    @foreach ($report as $key => $item)
                        <tr>
                            <td>
                                {{$item->id_horder}}
                            </td>
                            <td>
                                {{$item->id_dorder}}
                            </td>
                            <td>
                               {{$datamerchant[$key]->nama_merchant}}
                            </td>
                            <td>
                                {{$item->isi_report}}
                             </td>
                            <td>
                                <img src="{{asset("/storage/images_bukti_report/".$item->bukti_report)}}" width="300px">
                            </td>
                            <td>
                                <form action="{{url("admin/konfirmasiReport/$item->id_report/$item->id_horder")}}" method='GET'>
                                    @csrf
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#no{{$item->id_report}}">
                                        Konfirmasi
                                      </button>
                                      <!-- Modal -->
                                      <div class="modal fade" id="no{{$item->id_report}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                <form action="{{url("admin/rejectReport/$item->id_report/$item->id_horder")}}" method='GET'>
                                    @csrf
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#noreject{{$item->id_report}}">
                                        Reject
                                      </button>
                                      <!-- Modal -->
                                      <div class="modal fade" id="noreject{{$item->id_report}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalCenterTitle">Yakin Reject?</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              Yakin Reject?
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-danger">Reject</button>
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
</div>

@endsection

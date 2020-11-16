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
                    Gambar
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
                    @foreach ($dorder as $key => $item)

                        <tr>
                            <td>
                                {{$item->nama_barang}}
                            </td>
                            <td>
                                {{$item->nama_merchant}}
                            </td>
                            <td>
                                Rp. {{number_format($item->harga_barang),2,",","."}}
                            </td>
                            <td>
                                {{$item->jumlah_barang}}
                            </td>
                            <td>
                                <img src="{{asset("/storage/images/".$barang[$key]->gambar_barang)}}" width="200px">
                            </td>
                            <td>
                                Rp. {{number_format($item->jumlah_total),2,",","."}}

                            </td>
                            <td>
                                {{$item->status}}
                                @if ($item->status == "sudah dikirim")
                                <br><br>
                                    <form method="GET" action="/user/terima/{{$item->id_dorder}}">
                                        <label>Konfirmasi Penerimaan Barang : </label>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#no{{$item->id_dorder}}">
                                            Barang Telah Diterima
                                          </button>

                                          <!-- Modal -->
                                          <div class="modal fade" id="no{{$item->id_dorder}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalCenterTitle">Konfirmasi</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  Yakin telah diterima?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Ya</button>
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                              </div>
                                            </div>
                                    </form>
                                    @elseif ($item->status == "selesai")
                                    <br><br>
                                    <form method="POST" action="/user/review/{{$item->id_merchant}}/{{$item->id_dorder}}">
                                        @csrf

                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#no{{$item->id_dorder}}">
                                            Review
                                          </button>

                                          <!-- Modal -->
                                          <div class="modal fade" id="no{{$item->id_dorder}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalCenterTitle">Review Merchant</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>Review Merchant</h5>
                                                    <label>Nilai (1 - 5) : </label><br>
                                                    <input type="number" class='w-25 form-control' min="1" max="5" name="score">
                                                    <label>Isi Review : </label>
                                                    <textarea class="form-control" name="isi">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Review</button>
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                              </div>
                                            </div>
                                    </form>
                                @endif
                            </td>
                        </tr>

                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total: Rp. {{number_format($total),2,",","."}}</td>
                    </tr>
                @endif
            </tbody>
        </table><br>
    </div>
    @if ($status == "belum dibayar")
    <h2>Pembayaran</h2>
    <p>Rekening BCA <br> No Rekening : 1231 1232 12321</p>
    <form action="/user/bayar/{{$id_horder}}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3">
            <label class="form-label">Upload Bukti Pembayaran</label>
            <input class="form-control" type="file" name="gambar" class="form-control"><br>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                Bayar
              </button>
              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Yakin sudah transfer?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success">Bayar</button>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </form>
    @elseif ($status == "sudah dibayar")
        <h2>Status Pembayaran : </h2>
        <p>Sedang dalam proses verifikasi</p>
    @elseif ($status == "sudah dikonfirmasi")
        <h2>Status Pembayaran : </h2>
        <p>Pembayaran telah dikonfirmasi dan diteruskan ke penjual</p>
    @endif
</div>
@endsection

@extends('template')
@section('isi')
@include('alert')
<div class="container mt-5  text-success">
    <h1>Your Cart</h1>
    <div class="d-flex flex-row">
        <table class="table table-striped">
            <thead>
                <th>
                    Nama
                </th>
                <th>
                    Jumlah
                </th>
                <th>
                    Harga
                </th>
                <th>
                    Total
                </th>
                <th>
                    Action
                </th>
            </thead>
            <tbody>
                @if (isset($dataCart))

                    @method('GET')
                    @csrf
                    @php
                        $total=0;
                    @endphp
                    @foreach ($dataCart as $key=>$item)
                    <form action="{{url("barang/editItemCart/$key")}}" method="GET">
                        <tr>
                            <td>
                                {{$item['namaBarang']}}
                            </td>
                            <td>
                               <input type="number" min='0' class='w-25' size="3" maxlength='3' value="{{$item['jumlah']}}" name="jumlah">
                            </td>
                            <td>
                                Rp. {{number_format($item['harga']),2,",","."}}
                            </td>
                            <td>
                                Rp. {{number_format($item['harga']*$item['jumlah']),2,",","."}}
                            </td>
                            <td>
                                <a href="{{url("barang/removeItemCart/$key")}}" class='btn btn-danger'>Remove From Cart</a>
                                <button class="btn btn-warning" class='submit'>Edit</button>
                            </td>
                            @php
                                $total=$total+$item['harga']*$item['jumlah'];
                            @endphp
                        </tr>
                    </form>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total: Rp. {{number_format($total),2,",","."}}</td>
                    </tr>
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <h2>Tidak Ada Barang Dalam Cart</h2>
                        </td>
                    </tr>

                @endif

            </tbody>
        </table><br>
        
    </div>
    
    <form action="{{url('user/checkOut')}}" method="POST">
        @csrf
    <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
            Checkout
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <h2>Pilih Alamat</h2>
                    @if (isset($alamat))
                        <select name="alamat" id="">
                            @foreach ($alamat as $item)
                                <option value="{{$item->id_alamat}}">{{$item->alamat ." - ". $item->nama_penerima}}</option>
                            @endforeach
                        </select>
                        <br><br>
                    @else
                        Tidak ada alamat, silahkan tambah alamat terlebih dahulu <br>
                        <form action="user/alamat">
                            <button type="submit">Alamat</button>
                        </form>
                    @endif
                    <h3>Yakin checkout?</h2>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit">CheckOut</button>
                </div>
            </div>
            </div>
        </div>
    </form>
</div>

@endsection

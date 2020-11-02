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
    <form action="{{url('user/checkOut')}}">
        <button class="btn btn-success" type="submit">Check Out</button>
    </form>
</div>

@endsection

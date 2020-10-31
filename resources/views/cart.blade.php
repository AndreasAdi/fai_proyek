@extends('template')
@section('isi')

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
            </thead>
            <tbody>
                @if (isset($dataCart))
                    @php
                        $total=0;
                    @endphp
                    @foreach ($dataCart as $item)
                        <tr>
                            <td>
                                {{$item['namaBarang']}}
                            </td>
                            <td>
                                {{$item['jumlah']}}
                            </td>
                            <td>
                                Rp. {{number_format($item['harga']),2,",","."}}
                            </td>
                            <td>
                                Rp. {{number_format($item['harga']*$item['jumlah']),2,",","."}}
                            </td>
                            @php
                                $total=$total+$item['harga']*$item['jumlah'];
                            @endphp
                        </tr>
                    @endforeach
                    <tr>
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

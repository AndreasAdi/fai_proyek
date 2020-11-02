@extends('template')
@section('isi')

<div class="container mt-5  text-success">
    <h1>Wishlist</h1>
    <div class="d-flex flex-row">
        <table class="table table-striped">
            <thead>
                <th>
                    Nama
                </th>
                <th>
                    Harga
                </th>

            </thead>
            <tbody>
                @if (isset($wishlist))
                    @php
                        $total=0;
                    @endphp
                    @foreach ($wishlist as $item)
                        <tr>
                            <td>
                                {{$item['nama_barang']}}
                            </td>
                            <td>
                                Rp. {{number_format($item['harga']),2,",","."}}
                            </td>

                        </tr>
                    @endforeach

                @else


                @endif
            </tbody>
        </table><br>
    </div>
    <form action="{{url('user/checkOut')}}">
        {{-- <button class="btn btn-success" type="submit">Check Out</button> --}}
    </form>
</div>

@endsection

@extends('template')
@section('judul')
List Sale
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
                    Berlaku Sampai Dengan
                </th>
                <th>
                    Kategori
                </th>
                <th>
                    Action
                </th>
            </thead>
            <tbody>
                @if (isset($listSale))
                    @foreach ($listSale as $item)
                        <tr>
                            <td>
                                {{$item->nama_sales}}
                            </td>
                            <td>
                                {{$item->tanggal_habis}}
                            </td>
                            <td>
                                @foreach ($kategori as $itemkat)
                                    @if ($itemkat->id_kategori==$item->id_kategori)
                                        {{$itemkat->nama_kategori}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <a href="{{url("user/loadPageSale/$item->id_kategori")}}" class="btn btn-primary">Lihat Sale</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <h2>Tidak Ada Sale</h2>
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
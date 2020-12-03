@extends('template')
@section('judul')
Admin List Sale
@endsection
@section('isi')

<div class="container mt-5  text-success">
    <h1>List Sale</h1>
    @include('alert')
        <table class="table table-striped" id="table">
            <thead>
                <th>
                    Nama
                </th>
                <th>
                    Id Sale
                </th>
                <th>
                    Berlaku Sampai Dengan
                </th>
                <th>
                    Kategori
                </th>
                <th>
                    Status
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
                                {{$item->id_sales}}
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
                                @if ($item->deleted_at==null)
                                   <b><p class="text-success">Aktif</p></b>
                                @else
                                   <b><p class='text-danger'>Tidak Aktif</p></b>
                                @endif
                            </td>
                            <td>
                                @if ($item->deleted_at==null)
                                    <form action="{{url("sale/NonAktifkanSale/$item->id_sales")}}" method='POST'>
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger">Non-Aktif</button>
                                    </form>
                                @else
                                    <form action="{{url("sale/AktifkanSale/$item->id_sales")}}" method='POST'>
                                        @method('PATCH')
                                        @csrf
                                        <button class="btn btn-success">Aktif</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td></td>
                        <td></td>
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

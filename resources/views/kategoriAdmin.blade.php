@extends('template')
@section('judul')
List Kategori
@endsection
@section('isi')

<div class="container mt-5  text-success">
    <h1>List Kategori</h1>
    @include('alert')
        <table class="table table-striped" id="table">
            <thead>
                <th>
                    Nama
                </th>
                <th>
                    Id Kategori
                </th>
                <th>
                    Action
                </th>
            </thead>
            <tbody>
                @if (isset($listKategori))
                    @foreach ($listKategori as $item)
                        <tr>
                            <td>
                                {{$item->nama_kategori}}
                            </td>
                            <td>
                                {{$item->id_kategori}}
                            </td>
                            <td>
                                <form action="{{url("admin/deleteKategori/$item->id_kategori")}}" method='GET'>
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <h2>Tidak Ada Kategori</h2>
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

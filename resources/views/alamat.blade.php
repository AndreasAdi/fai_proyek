@extends('template')
@section('isi')

<div class="container mt-5  text-success">
    <h1>Alamat</h1>
    <div class="d-flex flex-row">
        <table class="table table-striped">
            <thead>
                <th>
                    Nama Penerima
                </th>
                <th>
                    Alamat
                </th>
                <th>
                    Telepon
                </th>
            </thead>
            <tbody>
                @if (isset($alamat))
                    @php
                        $total=0;
                    @endphp
                    @foreach ($alamat as $item)
                        <tr>
                            <td>
                                {{$item->nama_penerima}}
                            </td>
                            <td>
                                {{$item->alamat}}
                            </td>
                            <td>
                                {{$item->telepon}}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table><br>
    </div>
    <form action="{{url('user/tambahAlamat')}}" method="POST">
        @csrf
        <div class="container">
            Nama Penerima : <input class="form-control" type="text" name="namapenerima" id="">
            Alamat : <input class="form-control" type="text" name="alamat" id="">
            Telepon : <input class="form-control" type="text" name="telepon" id="">
            <Button class="btn btn-success mt-2" type="submit">Tambah Alamat</Button>
        </div>
    </form>
</div>

@endsection
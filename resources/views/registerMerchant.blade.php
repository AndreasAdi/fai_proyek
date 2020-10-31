@extends("template")
@section('isi')
@include('alert')
<form action="{{url('user/prosesRegisterMerchant')}}" method="POST">
    @method('POST')
    @csrf
    <div class="container">
        Nama Toko: <input class="form-control" type="text" name="regMerchant_nama" id="">
        Alamat Toko: <input class="form-control" type="text" name="regMerchant_alamat" id="">
        <Button class="btn btn-success mt-2" type="submit">Submit</Button>
    </div>

</form>

@endsection


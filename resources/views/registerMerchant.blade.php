@extends("template")
@section('judul')
Register Merchant
@endsection
@section('isi')
@include('alert')
<form action="{{url('user/prosesRegisterMerchant')}}" method="POST">
    @method('POST')
    @csrf
    <div class="container" style="margin-left: 34%; margin-top: 10%;">
        <div class="card" style="width: 31rem;">
            {{-- <img class="card-img-top" src="" alt="Card image cap"> --}}
            <div class="card-body">
                <h5 class="card-title">Toko Kamu Belum Didaftarkan</h5>
                <p class="card-text">Yuk, daftarkan toko kamu, dengan mengisi form di bawah ini</p>
                Nama Toko: <input class="form-control" type="text" name="regMerchant_nama" id="">
                Alamat Toko: <input class="form-control" type="text" name="regMerchant_alamat" id="">
                <Button class="btn btn-success mt-2" type="submit">Submit</Button>
            </div>
        </div>
    </div>

</form>

@endsection


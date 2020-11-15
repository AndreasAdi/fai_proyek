@extends('template')
@section('isi')
@include('alert')
@section('style')

@endsection


<div class="container bg-success mt-5 text-light shadow rounded">
    <div class="p-4">
        <h3>Review Merchant</h3>
    </div>
</div>
@isset($dataReview)
    @foreach ($dataReview as $key => $item)
    <div class="container bg-success mt-2 text-light shadow rounded">
        <div class="p-3">
            <h4>{{ $dataUser[$key]->nama_user }}</h4>
            <h5>Score : {{$item->score}}</h5>
            <h5>Isi Review</h5>
            <p>{{$item->isi_review}}</p>
        </div>
    </div>
    @endforeach
@endisset



@endsection

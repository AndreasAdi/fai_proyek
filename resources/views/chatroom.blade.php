@extends('template')
@section('judul')
Chat Room
@endsection
@section('isi')
@include('alert')


<div class="container mt-5 col-6">
    <h1 class="text-success">Chat List</h1>


<div class="d-flex flex-column">
    @foreach ($headerChat as $key => $item)

        <div class="shadow rounded p-3 mb-3">
           <b> {{$nama[$key]['nama_user']}}</b>
            <span class="ml-3 text text-secondary"> {{$item->last_message}}</span>
            <a href="{{url("user/loadDetailChat/$item[id_chatroom]")}}" class="btn btn-primary float-right">View Chat</a>
        </div>


        @endforeach
</div>
</div>
    @endsection


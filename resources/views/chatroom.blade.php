@extends('template')
@section('judul')
Chat Room
@endsection
@section('isi')
@include('alert')


<div class="container mt-5 col-6">
    <h1 class="text-success">Chat Room</h1>
        <form action={{url("user/searchChat")}} method="POST">
            @method('POST')
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Nama User"  name="KeySearchNamaUser" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                </div>
              </div>
        </form>
        <a href='{{url("user/loadChatroom")}}' class="btn btn-success mb-3 form-control">Reset</a>

<div class="d-flex flex-column">
    @foreach ($headerChat as $key => $item)

        <div class="shadow rounded p-3 mb-3">
           <b> {{$nama[$key]['nama_user']}}</b><br>
            <span class="text text-secondary"> {{$item->last_message}}</span>
            <a href="{{url("user/loadDetailChat/$item[id_chatroom]")}}" class="btn btn-success float-right">View Chat</a>
        </div>


        @endforeach
</div>
</div>
    @endsection


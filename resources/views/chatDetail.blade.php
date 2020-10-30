@extends('template')
@section('judul')
Chat Room
@endsection
@section('isi')
@include('alert')
        <div class="container mt-5 col-6">
            @if ($id_sender==Session::get('userId'))
                <h1 class='text-success'>{{$namaRecepient}}</h1>
            @else
                <h1 class='text-success'>{{$namaSender}}</h1>
            @endif
            <form action='{{url("user/insertDetail")}}' method="POST">
                @method('POST')
                @csrf
                <input type="hidden" name='idChatroom' value="{{$idChatroom}}">
                @if (isset($detailChat))
                    @foreach ($detailChat as $item)
                        @if (Session::get('userId')==$item['id_user'])
                            <div class="container bg-success">
                                @if ($id_sender==$item['id_user'])
                                    <p class="text-light">Sender</p>
                                    <p class="text-light">{{$namaSender}}</p>
                                    <p class="text-light">{{$item['chat']}}</p>
                                @else
                                    <p class="text-light">Recepient</p>
                                    <p class="text-light">{{$namaRecepient}}</p>
                                    <p class="text-light">{{$item['chat']}}</p>
                                @endif
                            </div>
                        @else
                            <div class='container bg-primary'>
                                @if ($id_sender==$item['id_user'])
                                    <p class="text-light">Sender</p>
                                    <p class="text-light">{{$namaSender}}</p>
                                    <p class="text-light">{{$item['chat']}}</p>
                                @else
                                    <p class="text-light">Recepient</p>
                                    <p class="text-light">{{$namaRecepient}}</p>
                                    <p class="text-light">{{$item['chat']}}</p>
                                @endif
                            </div>
                        @endif
                    @endforeach
                @else
                    <p>Tidak Ada Chat</p><br>
                @endif
                <input type="text" name='message' class="form-control">
                <button type="submit" class="btn btn-success">Send</button>
            </form>
        </div>
    @endsection


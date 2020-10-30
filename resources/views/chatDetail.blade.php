@extends('template')
@section('judul')
Chat Room
@endsection
@section('isi')
@include('alert')
        <div class="container mt-5 col-6">
            <form action='url("user/insertDetail")' method="POST">
                @method('POST')
                @csrf
                <input type="hidden" name='idChatroom' value="{{$idChatroom}}">
                @foreach ($detailChat as $item)
                        @if ($item['id_user']==$idSender)
                            <div class="container bg-success">
                                <p>Sender</p><br>
                                {{$item['id_sender']}} <br>
                                {{$item['chat']}}
                            </div>
                        @else
                            <div class='container bg-primary'>
                                <p>Recepient</p><br>
                                {{$item['id_recepient']}}
                                {{$item['chat']}}
                            </div>
                    @endif
                @endforeach

                <input type="text" name='message' class="form-control">
                <button type="submit" class="btn btn-success">Send</button>
            </form>
        </div>
    @endsection
@endsection

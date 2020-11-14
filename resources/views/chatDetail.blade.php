@extends('template')
@section('judul')
Chat Room
@endsection
@section('isi')
@include('alert')
        <div class="container mt-5 col-6 p-5 shadow">
            @if ($id_sender==Session::get('userId'))
                <h1 class='text-success'>{{$namaRecepient}}</h1>
            @else
                <h1 class='text-success'>{{$namaSender}}</h1>
            @endif
            <hr>
            <div style="height: 250px;overflow-y: scroll;" class="container mt-5">
                <form action='{{url("user/insertDetail")}}' method="POST">
                    @method('POST')
                    @csrf
                    <input type="hidden" name='idChatroom' value="{{$idChatroom}}">
                    @if (isset($detailChat))
                        @foreach ($detailChat as $item)
                            @if (Session::get('userId')==$item['id_user'])
                                <div class="d-flex align-items-end flex-column bd-highlight mb-3">
                                    @if ($id_sender==$item['id_user'])
                                    <div style="background-color: #97c9b2" class="pl-4 pr-4 pt-2 col col-md-auto bd-highlight col-2  rounded-pill">
                                        <p class="text-light">{{$item['chat']}}</p>
                                    </div>
                                    @else
                                    <div  class="pl-4 pr-4 pt-2 col col-md-auto bd-highlight col-2  rounded-pill  bg-success bg-gradient">
                                        <p class="text-light">{{$item['chat']}}</p>
                                    </div>
                                    @endif
                                </div>

                            @else
                                    <div class="d-flex align-items-start flex-column bd-highlight mb-3">
                                        @if ($id_sender==$item['id_user'])
                                        <div class="pl-4 pr-4 pt-2 bd-highlight col col-md-auto rounded-pill bg-secondary bg-gradient">
                                            <p class="text-light text-center">{{$item['chat']}}</p>

                                        </div>
                                        <br>
                                        @else
                                        <div class="pl-4 pr-4 pt-2 bd-highlight col col-md-auto bg-primary rounded-pill float-left">
                                            <p  class="text-light text-center">{{$item['chat']}}</p>

                                        </div>
                                        <br>
                                        @endif
                                    </div>

                            @endif
                        @endforeach
                    @else
                        <p>Tidak Ada Chat</p><br>
                    @endif

            </div>
                <hr>
                <div class="input-group mt-5 mb-3">
                    <input type="text" class="form-control" placeholder="Masukkan Pesan" aria-label="Recipient's username" aria-describedby="button-addon2" name="message">
                    <button class="btn btn-success bg-gradient" type="submit" id="button-addon2">Send</button>
                  </div>
                {{-- <input type="text" name='message' class="form-control">
                <button type="submit" class="btn btn-success">Send</button> --}}
            </form>
        </div>
    @endsection


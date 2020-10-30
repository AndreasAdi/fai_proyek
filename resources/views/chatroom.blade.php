@extends('template')
@section('judul')
Chat Room
@endsection
@section('isi')
@include('alert')


<div class="container mt-5 col-6">
    <h1>Chat List</h1>
<table class='table table-dark'>
    <thead>
        <th></th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($headerChat as $item)
        <tr>
            <td>
                @if ($item['id_sender']==Session::get('userId'))
                    {{$item['id_recepient']}}
                @else
                    {{$item['id_sender']}}
                @endif

            </td>
            <td>{{$item['updated_at']}}</td>
            <td><a href="{{url("user/loadDetailChat/$item[id_chatroom]/$item[id_recepient]/$item[id_sender]")}}">View Chat</a></td>
        </tr>
        @endforeach

    </tbody>
</table>
</div>
    @endsection
@endsection


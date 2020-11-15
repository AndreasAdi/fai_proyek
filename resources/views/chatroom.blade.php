@extends('template')
@section('judul')
Chat Room
@endsection
@section('isi')
@include('alert')


<div class="container mt-5 col-6">
    <h1 class="text-success">Chat List</h1>
<table class='table table-hover'>
    <thead class="bg-success text-light text-center">
        <th>Reciver</th>
        <th>Nama</th>
        <th>Last Message</th>
        <th>Action</th>
    </thead>
    <tbody class="text-center">
        @foreach ($headerChat as $key => $item)
        <tr>
            <td>
                @if ($item->id_sender==Session::get('userId'))
                    {{$item->id_recepient}}
                @else
                    {{$item->id_sender}}
                @endif

            </td>
            <td>
                {{$nama[$key]['nama_user']}}
            </td>
            <td>{{$item->updated_at->format('Y-m-d H:i:s')}}</td>
            <td><a href="{{url("user/loadDetailChat/$item[id_chatroom]")}}" class="btn btn-primary">View Chat</a></td>
        </tr>
        @endforeach

    </tbody>
</table>
</div>
    @endsection


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
            <td style="padding-top: 13px;">
                @if ($item->id_sender==Session::get('userId'))
                    {{$item->id_recepient}}
                @else
                    {{$item->id_sender}}
                @endif

            </td>
            <td style="padding-top: 13px;">
                {{$nama[$key]['nama_user']}}
            </td style="padding-top: 13px;">
            <td style="padding-top: 13px;">{{$item->updated_at->format('Y-m-d H:i:s')}}</td>
            <td>
                <a href="{{url("user/loadDetailChat/$item[id_chatroom]")}}" class="btn btn-primary">
                <svg width="1em" height="1em" viewBox="0 1 18 18" class="bi bi-chat-dots-fill" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                </svg>
                Chat
                </a>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
</div>
    @endsection


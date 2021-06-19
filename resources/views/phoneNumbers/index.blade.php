@extends('base')

@section('main')

    <div class="mt-5">
        <h1 class="display-5">Contacts created by "{{auth()->user()->name}}"</h1>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
            <tr class="table-primary">
                <td># ID</td>
                <td>Name</td>
                <td>Phone number</td>
                <td>Record owner</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
            @foreach($phoneNumbers as $phoneNumber)
                <tr>
                    <td>{{$phoneNumber->id}}</td>
                    <td>{{$phoneNumber->name}}</td>
                    <td>{{$phoneNumber->phonenumber}}</td>
                    <td>{{$phoneNumber->user->name}}
                        @if ($phoneNumber->user_id == auth()->id())
                            <b>(Me)</b>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('phoneNumbers.show', $phoneNumber->id)}}" class="btn btn-success btn-sm">Show</a>
                        @if ($phoneNumber->user_id == auth()->id())
                        <a href="{{ route('phoneNumbers.edit', $phoneNumber->id)}}" class="btn btn-success btn-sm">Edit</a>
                        <form action="{{ route('phoneNumbers.destroy', $phoneNumber->id)}}" method="post" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                        <a href="{{ route('phoneNumbers.share', $phoneNumber->id)}}" class="btn btn-primary btn-sm">Share</a>
                        @else
                            <p class="text-danger">Not allowed any actions</p>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
@endsection

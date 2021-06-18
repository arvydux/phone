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
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($phoneNumbers as $phoneNumber)
                <tr>
                    <td>{{$phoneNumber->id}}</td>
                    <td>{{$phoneNumber->name}}</td>
                    <td>{{$phoneNumber->phonenumber}}</td>
                    <td class="text-center">
                        <a href="{{ route('phoneNumbers.edit', $phoneNumber->id)}}" class="btn btn-success btn-sm">Edit</a>
                        <form action="{{ route('phoneNumbers.destroy', $phoneNumber->id)}}" method="post" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
@endsection

@extends('base')

@section('main')

    <div class="mt-4">
        <div class="col-md-12 text-right">
            <a href="{{ route('phone-numbers.create')}}" class="btn btn-success">Create record</a>
        </div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Contacts created by "{{auth()->user()->name}}"
        </h2>
    </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <table class="table mt-4">
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
                        <a href="{{ route('phone-numbers.show', $phoneNumber->id)}}" class="btn btn-success">Show</a>
                        @if ($phoneNumber->user_id == auth()->id())
                        <a href="{{ route('phone-numbers.edit', $phoneNumber->id)}}" class="btn btn-success">Edit</a>
                        <form action="{{ route('phone-numbers.destroy', $phoneNumber->id)}}" method="post" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                        <a href="{{ route('phone-numbers.share', $phoneNumber->id)}}" class="btn btn-primary">Share</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
@endsection

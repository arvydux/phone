@extends('base')

@section('main')
    <div class="card mt-5">
        <div class="card-header">
            Update
        </div>

        <div class="card-body">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="form-group">
                    @if(isset($photo))
                        <img src="{{asset("storage/photo/".$photo)}}" alt="">
                    @else
                        <img src="{{url('images/person.jpg')}}" alt="" class="w-25">
                    @endif
                </div>
                <form method="post" action="{{ route('photos.update', $phoneNumber->id) }}"  enctype="multipart/form-data">
                    <div class="form-group">
                        @csrf
                        <input type="file" name="file">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Change photo</button>
                        <a href="{{ route('photos.delete', $phoneNumber->id)}}" class="btn btn-success">Delete photo</a>
                    </div>
                </form>
                <form method="post" action="{{ route('phone-numbers.update', $phoneNumber->id) }}">
                <div class="form-group">
                    @csrf
                    @method('PATCH')
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $phoneNumber->name }}" />
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" class="form-control" name="phonenumber" value="{{ $phoneNumber->phonenumber }}" />
                </div>
                <button type="submit" class="btn btn-block btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection

@extends('base')

@section('main')
    <div class="card mt-5">
        <div class="card-header">
            Share record with other users
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="{{ route('phone-numbers.makeShare', $phoneNumber->id) }}">
                <div class="form-group">
                    @csrf
                    @method('PATCH')
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $phoneNumber->name }}" disabled/>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" class="form-control" name="phonenumber" value="{{ $phoneNumber->phonenumber }}" disabled/>
                </div>
                <div>
                    <label >Share this record with users:</label>
                </div>
                <div class="form-group">
                @foreach ($users as $user)
                    <input type="checkbox"  name="user-id[]" value="{{ $user->id }}"
                            @if ($phoneNumber->shared_user_ids != null)
                                @if (in_array($user->id, json_decode($phoneNumber->shared_user_ids)))
                                    checked
                                @endif
                            @endif>
                    <label> {{ $user->name }}</label><br>
                @endforeach
                </div>
                <button type="submit" class="btn btn-block btn-primary">Share</button>
            </form>
        </div>
    </div>
@endsection

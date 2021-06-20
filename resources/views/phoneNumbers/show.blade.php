@extends('base')

@section('main')
    <div class="card mt-5">
        <div class="card-header">
            Show full record info
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
            <form method="get" action="{{ route('phone-numbers.index', $phoneNumber->id) }}">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ $phoneNumber->name }}" />
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text"  class="form-control" value="{{ $phoneNumber->phonenumber }}" />
                </div>
                <div class="form-group">
                    <label>Created by</label>
                    <input type="text"  class="form-control" value="{{ $phoneNumber->user->name}}" />
                </div>
                <div class="form-group">
                    <label>Last updated at</label>
                    <input type="text"  class="form-control" value="{{ $phoneNumber->updated_at }}" />
                </div>
                <div class="form-group">
                    <label>Shared with:</label><br>
                    @foreach ($users as $user)
                        @if ($phoneNumber->shared_user_ids != null)
                            @if (in_array($user->id, json_decode($phoneNumber->shared_user_ids)))
                                <label>- {{ $user->name }}</label><br>
                            @endif
                        @endif
                    @endforeach
                </div>
                <button type="submit" class="btn btn-block btn-danger">Back to the records list</button>
            </form>
        </div>
    </div>
@endsection

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
                    @if(isset($photo))
                        <img src="{{asset("storage/photo/".$photo)}}" alt="">
                    @else
                        <img src="{{url('images/person.jpg')}}" alt="" class="w-25">
                    @endif
                </div>
                <div class="form-group">
                    <label><b>Name</b></label>
                    <input type="text" name="name" class="form-control" value="{{ $phoneNumber->name }}" />
                </div>
                <div class="form-group">
                    <label><b>Phone</b></label>
                    <input type="text" name="phone"  class="form-control" value="{{ $phoneNumber->phonenumber }}" />
                </div>
                <div class="form-group">
                    <label><b>Created by</b></label>
                    <input type="text"  name="owner" class="form-control" value="{{ $phoneNumber->user->name}}" />
                </div>
                <div class="form-group">
                    <label><b>Last updated at</b></label>
                    <input type="text"  name="updated-at" class="form-control" value="{{ $phoneNumber->updated_at }}" />
                </div>
                <div class="form-group">
                    <label><b>Shared with:</b></label><br>
                        @foreach ($users as $user)
                            @if ($phoneNumber->shared_user_ids != null)
                                @if (in_array($user->id, json_decode($phoneNumber->shared_user_ids)))
                                    <label>- {{ $user->name }}</label><br>
                                @endif
                            @endif
                        @endforeach
                </div>
                <div class="form-group">
                    <label><b>QR code</b></label>
                    {!! QrCode::size(250)->generate("$phoneNumber->name.':'.$phoneNumber->phoneNumber,"); !!}
                </div>
                <button type="submit" class="btn btn-block btn-primary">Back to the records list</button>
            </form>
        </div>
    </div>
@endsection

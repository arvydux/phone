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
                    <label>{{ $phoneNumber->name }}</label>
                </div>
                <div class="form-group">
                    <label><b>Phone</b></label>
                    <label>{{ $phoneNumber->phonenumber }}</label>
                </div>
                <div class="form-group">
                    <label><b>Created by</b></label>
                    <label>{{ $phoneNumber->user->name}}</label>
                </div>
                <div class="form-group">
                    <label><b>Last updated at</b></label>
                    <label>{{ $phoneNumber->updated_at }}</label>
                </div>
                <div class="form-group">
                    <label for="phones"><b>Additional phone numbers</b></label><br>
                    @foreach ($phones as $phone)
                        <div class="form-group">
                            <label>{{ $phone->number }}</label>
                        </div>
                    @endforeach
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
                <a href="{{ route('phone-numbers.index')}}" class="btn btn-block btn-primary">Back to the records list</a>
            </form>
        </div>
    </div>
@endsection

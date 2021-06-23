@extends('base')

@section('main')
    <div class="card mt-5">
        <div class="card-header">
            <b>Update</b>
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
                <div class="form-group">
                    <label for="name"><b>Name</b></label>
                    <input type="text" class="form-control" name="name" value="{{ $phoneNumber->name }}" disabled/>
                </div>
                <div class="form-group">
                    <label for="phone"><b>Phone</b></label>
                    <input type="tel" class="form-control" name="phonenumber" value="{{ $phoneNumber->phonenumber }}" disabled/>
                </div>
                <div class="form-group">
                    <label for="phones"><b>Additional phone numbers</b></label><br>
                    @foreach ($phones as $phone)
                    <div class="form-group">
                        <form  method="POST" style="display:inline" action="{{ route('phones.update', ['id' => $phoneNumber->id, 'phone' => $phone->id]) }}">
                            <input type="text" class=" w-25 p-1" name="number" value="{{ $phone->number }}" />
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">Update number</button>
                        </form>
                        <form  method="POST" style="display:inline" action="{{ route('phones.destroy', ['id' => $phoneNumber->id, 'phone' => $phone->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete number</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            <form method="post" action="{{ route('phones.store', $phoneNumber->id) }}">
                @csrf
                <div class="form-group">
                    <label for="phone"><b>New phone</b></label><br>
                    <input type="tel" class="w-25 p-1" name="number" value="" />
                    <button type="submit" class="btn btn-success">Add number</button>
                </div>
            </form>
                <div class="form-group">
                    <a href="{{ route('phone-numbers.index')}}" class="btn btn-block btn-primary">Back to the records list</a>
                </div>
        </div>
    </div>
@endsection

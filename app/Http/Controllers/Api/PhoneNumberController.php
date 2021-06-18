<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PhoneNumber;

class PhoneNumberController extends Controller
{
    public function index(Request $request)
    {
        $phoneNumbers = PhoneNumber::all()->where('user_id', auth()->id());
        return response()->json([
            "success" => true,
            "message" => "User's '".auth()->user()->name."' created phone number list",
            "data" => $phoneNumbers
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'phonenumber' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = array_merge($input,[ 'user_id' => auth()->id()]);
        $phoneNumber = PhoneNumber::create($input);
        return response()->json([
            "success" => true,
            "message" => "Phone number created successfully.",
            "data" => $phoneNumber
        ]);
    }

    public function show($id)
    {
        $phoneNumber = PhoneNumber::find($id);
        if (is_null($phoneNumber)) {
            return $this->sendError('PhoneNumber not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "PhoneNumber retrieved successfully.",
            "data" => $phoneNumber
        ]);
    }

    public function update(Request $request, PhoneNumber $phoneNumber)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'phonenumber' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $phoneNumber->name = $input['name'];
        $phoneNumber->phonenumber = $input['phonenumber '];
        $phoneNumber->save();
        return response()->json([
            "success" => true,
            "message" => "Phone number updated successfully.",
            "data" => $phoneNumber
        ]);
    }

    public function destroy(PhoneNumber $phoneNumber)
    {
        $phoneNumber->delete();
        return response()->json([
            "success" => true,
            "message" => "Phone number deleted successfully.",
            "data" => $phoneNumber
        ]);
    }

}

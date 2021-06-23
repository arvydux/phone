<?php

namespace App\Services;

use App\Models\PhoneNumber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ShareService
{
    public function show($id)
    {
        $phoneNumber = PhoneNumber::find($id);
        if (! Gate::allows('share-phone-number', $phoneNumber)) {
            abort(403);
        }
        $phoneNumber = PhoneNumber::findOrFail($id);
        $users= User::where('id', '!=', auth()->id())->get();
        return view('phonenumbers.share', compact('phoneNumber', 'users'));
    }

    public function make(Request $request, $id)
    {
        $userIDs = $request->input('user-id');
        $phoneNumber = PhoneNumber::find($id);
        $phoneNumber->shared_user_ids = $userIDs;
        $phoneNumber->save();
        return redirect('/phone-numbers')->with('success', 'Phone number shared');

    }
}

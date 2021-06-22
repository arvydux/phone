<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PhoneNumber;
use Illuminate\Support\Facades\Gate;
use App\Traits\PhotoTrait;

class PhoneNumberController extends Controller
{
    use PhotoTrait;

    public function index()
    {
        $phoneNumbers = PhoneNumber::with('user')
            ->where('user_id', auth()->id())
            ->orWhereJsonContains('shared_user_ids', (string)auth()->id())->get();
        return view('phonenumbers.index', compact('phoneNumbers'));
    }

    public function create()
    {
        return view('phonenumbers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'phone-number'=>'required',
        ]);

        $phoneNumber = new PhoneNumber([
            'name' => $request->get('name'),
            'phonenumber' => $request->get('phone-number'),
            'user_id' => auth()->id()
        ]);
        $phoneNumber->save();
        $this->storePhoto($request, $phoneNumber->id);
        return redirect('/phone-numbers')->with('success', 'Phone number saved!');
    }

    public function show($id)
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        if (! Gate::allows('view-phone-number', $phoneNumber)) {
            abort(403);
        }
        $phoneNumber = PhoneNumber::findOrFail($id);
        $users = User::where('id', '!=', auth()->id())->get();
        \QrCode::size(500)
            ->format('png')
            ->generate($phoneNumber->name.':'.$phoneNumber->phoneNumber, public_path('images/qrcode.png'));
        $photo = $this->showPhoto($phoneNumber->id);
        return view('phonenumbers.show', compact('phoneNumber', 'users', 'photo'));
    }

    public function edit($id)
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        if (! Gate::allows('update-phone-number', $phoneNumber)) {
            abort(403);
        }
        $photo = $this->showPhoto($phoneNumber->id);
        return view('phonenumbers.update', compact('phoneNumber', 'photo'));
    }

    public function update(Request $request, $id)
    {
        $phoneNumber = PhoneNumber::find($id);
        if (! Gate::allows('update-phone-number', $phoneNumber)) {
            abort(403);
        }
        $data = $request->validate([
            'name' => 'required|max:255',
            'phonenumber' => 'required|numeric',
        ]);

        PhoneNumber::where('id', $id)->update($data);
        return redirect('/phone-numbers')->with('success', 'Phone number updated');
    }


    public function share($id)
    {
        $phoneNumber = PhoneNumber::find($id);
        if (! Gate::allows('share-phone-number', $phoneNumber)) {
            abort(403);
        }
        $phoneNumber = PhoneNumber::findOrFail($id);
        $users= User::where('id', '!=', auth()->id())->get();
        return view('phonenumbers.share', compact('phoneNumber', 'users'));
    }

    public function makeShare(Request $request, $id)
    {
        $userIDs = $request->input('user-id');
        $phoneNumber = PhoneNumber::find($id);
        $phoneNumber->shared_user_ids = $userIDs;
        $phoneNumber->save();
        return redirect('/phone-numbers')->with('success', 'Phone number shared');

    }

    public function updatePersonPhoto(Request $request, $id)
    {
        if ($this->updatePhoto($request, $id))
        $request->session()->flash('success', 'Photo updated');
        return redirect()->route('phone-numbers.edit', $id);
    }

    public function deletePersonPhoto(Request $request, $id)
    {
        if ($this->deletePhoto($id))
        $request->session()->flash('success', 'Photo deleted');
        return redirect()->route('phone-numbers.edit', $id);
    }

    public function destroy($id)
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        $phoneNumber->delete();
        return redirect('/phone-numbers')->with('success', 'Phone number deleted');
    }
}

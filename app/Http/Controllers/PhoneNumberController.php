<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\User;
use App\Services\PhotoService;
use App\Services\ShareService;
use Illuminate\Http\Request;
use App\Models\PhoneNumber;
use Illuminate\Support\Facades\Gate;

class PhoneNumberController extends Controller
{
    protected $userService;

    public function __construct(PhotoService $photoService, ShareService $shareService)
    {
        $this->photoService = $photoService;
        $this->shareService = $shareService;
    }

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
            'phone-number'=>'required|numeric',
        ]);

        $phoneNumber = new PhoneNumber([
            'name' => $request->get('name'),
            'phonenumber' => $request->get('phone-number'),
            'user_id' => auth()->id()
        ]);
        $phoneNumber->save();
        $this->photoService->store($request, $phoneNumber->id);
        return redirect('/phone-numbers')->with('success', 'Phone number saved!');
    }

    public function show($id)
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        if (! Gate::allows('view-phone-number', $phoneNumber)) {
            abort(403);
        }
        $users = User::where('id', '!=', auth()->id())->get();
        \QrCode::size(500)
            ->format('png')
            ->generate($phoneNumber->name.':'.$phoneNumber->phoneNumber, public_path('images/qrcode.png'));
        $photo = $this->photoService->show($phoneNumber->id);
        $phones = Phone::where('phone_number_id', $id)->get();
        return view('phonenumbers.show', compact('phoneNumber', 'users', 'photo', 'phones'));
    }

    public function edit($id)
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        if (! Gate::allows('update-phone-number', $phoneNumber)) {
            abort(403);
        }
        $photo = $this->photoService->show($phoneNumber->id);
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


    public function showShare($id)
    {
        return $this->shareService->show($id);
    }

    public function makeShare(Request $request, $id)
    {
        return $this->shareService->make($request, $id);
    }

    public function updatePersonPhoto(Request $request, $id)
    {
        if ($this->photoService->update($request, $id))
        $request->session()->flash('success', 'Photo updated');
        return back();
    }

    public function deletePersonPhoto(Request $request, $id)
    {
        if ($this->photoService->delete($id))
        $request->session()->flash('success', 'Photo deleted');
        return back();
    }

    public function destroy($id)
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        $phoneNumber->delete();
        return redirect('/phone-numbers')->with('success', 'Phone number deleted');
    }
}

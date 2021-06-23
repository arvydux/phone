<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\User;
use App\Services\PhoneNumberService;
use App\Services\PhotoService;
use App\Services\ShareService;
use Illuminate\Http\Request;
use App\Models\PhoneNumber;
use Illuminate\Support\Facades\Gate;

class PhoneNumberController extends Controller
{
    protected $userService;

    public function __construct(PhotoService $photoService, ShareService $shareService, PhoneNumberService $phoneNumberService)
    {
        $this->photoService = $photoService;
        $this->shareService = $shareService;
        $this->phoneNumberService = $phoneNumberService;
    }

    public function index()
    {
        $phoneNumbers = $this->phoneNumberService->index();

        return view('phonenumbers.index', compact('phoneNumbers'));
    }

    public function create()
    {
        return view('phonenumbers.create');
    }

    public function store(Request $request)
    {
        $phoneNumber = $this->phoneNumberService->store($request);
        $this->photoService->store($request, $phoneNumber->id);

        return redirect('/phone-numbers')->with('success', 'Phone number saved!');
    }

    public function show($id)
    {
        $phoneNumber = $this->phoneNumberService->show($id);
        $users = User::where('id', '!=', auth()->id())->get();
        $photo = $this->photoService->show($phoneNumber->id);
        $phones = Phone::where('phone_number_id', $id)->get();

        return view('phonenumbers.show', compact('phoneNumber', 'users', 'photo', 'phones'));
    }

    public function edit($id)
    {
        $phoneNumber = $this->phoneNumberService->edit($id);
        $photo = $this->photoService->show($phoneNumber->id);

        return view('phonenumbers.update', compact('phoneNumber', 'photo'));
    }

    public function update(Request $request, $id)
    {
        $this->phoneNumberService->update($request, $id);

        return redirect('/phone-numbers')->with('success', 'Phone number updated');
    }

    public function destroy($id)
    {
        $this->phoneNumberService->destroy($id);

        return redirect('/phone-numbers')->with('success', 'Phone number deleted');
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

}

<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Traits\PhotoTrait;

class PhoneController extends Controller
{
    use PhotoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $phoneNumber = PhoneNumber::find($id);
        if (! Gate::allows('update-phone-number', $phoneNumber)) {
            abort(403);
        }
        $phoneNumber = PhoneNumber::findOrFail($id);
        $photo = $this->showPhoto($phoneNumber->id);
        $phones = Phone::where('phone_number_id', $id)->get();
        return view('phones.index', compact('phoneNumber','photo', 'phones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request, $phoneNumberId)
    {
        $request->validate([
            'number'=>'required|numeric',
        ]);

        $phone = new Phone([
            'number' => $request->get('number'),
            'phone_number_id' => $phoneNumberId
        ]);
        $phone->save();

        return back()->with('success', 'One more phone number saved!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return 23333;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $phoneId)
    {
        $data = $request->validate([
            'number' => 'required|numeric',
        ]);

        Phone::where('id', $phoneId)->update($data);
        return back()->with('success', 'Additional phone number updated');
    }

    public function destroy($id, $phoneId)
    {
        $phone = Phone::findOrFail($phoneId);
        $phone->delete();
        return back()->with('success', 'Additional phone number deleted');
    }
}

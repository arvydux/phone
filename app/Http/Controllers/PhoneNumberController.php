<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneNumber;

class PhoneNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phoneNumbers = PhoneNumber::all()->where('user_id', auth()->id());;

        return view('phoneNumbers.index', compact('phoneNumbers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('phoneNumbers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        return redirect('/phoneNumbers')->with('success', 'Phone number saved!');
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
        $phoneNumber = PhoneNumber::findOrFail($id);
        return view('phoneNumbers.update', compact('phoneNumber'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'phonenumber' => 'required|numeric',
        ]);

        PhoneNumber::whereId($id)->update($data);
        return redirect('/phoneNumbers')->with('success', 'Phone number updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        $phoneNumber->delete();

        return redirect('/phoneNumbers')->with('success', 'Phone number deleted');
    }
}

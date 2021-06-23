<?php


namespace App\Services;


use App\Models\Phone;
use App\Models\PhoneNumber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PhoneNumberService
{
    public function index()
    {
        return PhoneNumber::with('user')
            ->where('user_id', auth()->id())
            ->orWhereJsonContains('shared_user_ids', (string)auth()->id())->get();
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

         return $phoneNumber;
    }

    public function show($id)
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        if (! Gate::allows('view-phone-number', $phoneNumber)) {
            abort(403);
        }
        \QrCode::size(500)
            ->format('png')
            ->generate($phoneNumber->name.':'.$phoneNumber->phoneNumber, public_path('images/qrcode.png'));

        return $phoneNumber;
    }

    public function edit($id)
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        if (! Gate::allows('update-phone-number', $phoneNumber)) {
            abort(403);
        }

        return $phoneNumber;
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
    }

    public function destroy($id)
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        $phoneNumber->delete();
        return $phoneNumber;
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Address;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::all();
        $primaryAddress = Address::where('is_primary', true)->first();
        return view('profile.address.show', compact('addresses', 'primaryAddress'), [
            'title' => 'address',
        ]);
    }

    public function setPrimary(Address $address)
    {
        // Unset the current primary address
        Address::where('is_primary', true)->update(['is_primary' => false]);

        // Set the selected address as primary
        $address->update(['is_primary' => true]);

        return redirect('/profile/address')->with('success', 'Primary address has been set!');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|max:255',
            'phone_number' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'district' => 'required|integer',
            'subdistrict' => 'required'
        ]);

        $validatedData = Address::create($validatedData);

        return redirect('/profile/address/')->with('success', 'New address has been added!');
    }

    public function show(Address $address)
    {
        return view('profile.address.show', [
            'title' => 'Show Address',
            'address' => $address
        ]);
    }

    public function edit(Address $address)
    {
        return view('profile.address.edit', [
            'address' => $address
        ]);
    }

    public function update(Request $request, Address $address)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|max:255',
            'phone_number' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'province' => 'required|numeric',
            'city' => 'required|numeric',
            'district' => 'required|integer',
            'subdistrict' => 'required'
        ]);

        $address->update($validatedData);

        return redirect('/profile/address')->with('success', 'Address has been updated');
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return redirect('/profile/address')->with('success', 'Address has been deleted!');
    }
}
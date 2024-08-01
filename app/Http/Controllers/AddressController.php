<?php

// namespace App\Http\Controllers;
// use App\Models\Address;
// use Illuminate\Support\Facades\Http;

// use Illuminate\Http\Request;

// class AddressController extends Controller
// {
//     public function index()
//     {

//         $responseProvince = Http::withHeaders([
//             'key' => 'acbba820fb1f76d8adff38610a3a253d'
//         ])->get('https://api.rajaongkir.com/starter/province');
//         $provinces = $responseProvince['rajaongkir']['results'];

//         $responseCity = Http::withHeaders([
//             'key' => 'acbba820fb1f76d8adff38610a3a253d'
//         ])->get('https://api.rajaongkir.com/starter/city');
//         $cities = $responseCity['rajaongkir']['results'];
//         $addresses = Address::all();
//         $primaryAddress = Address::where('is_primary', true)->first();
//         return view('profile.address.show', compact('addresses', 'primaryAddress'), [
//             'title' => 'address',
//             'provinces' => $provinces, 
//             'cities' => $cities, 
//         ]);
//     }
//     public function setPrimary(Request $request, $id)
//     {
//         $address = Address::findOrFail($id);

//         // Reset semua alamat ke non-primary
//         Address::where('user_id', auth()->id())->update(['is_primary' => false]);

//         // Set alamat ini sebagai primary
//         $address->is_primary = true;
//         $address->save();

//         return redirect()->back()->with('success', 'Alamat utama telah diperbarui.');
//     }

//     public function store(Request $request)
//     {
//         $validatedData = $request->validate([
//             'full_name' => 'required|max:255',
//             'phone_number' => 'required',
//             'email' => 'required|email',
//             'address' => 'required',
//             'province' => 'required',
//             'city' => 'required'
//         ]);
//         $validatedData['user_id'] = auth()->id();
//         $validatedData['province_id'] = $request->input('province');
//         $validatedData['city_id'] = $request->input('city');

//         $validatedData = Address::create($validatedData);

//         return redirect('/profile/address')->with('success', 'New address has been added!');
//     }

//     public function show(Address $address)
//     {
//         return view('profile.address.show', [
//             'title' => 'Show Address',
//             'address' => $address
//         ]);
//     }

//     public function edit(Address $address)
//     {
//         return view('profile.address.edit', [
//             'address' => $address
//         ]);
//     }

//     public function update(Request $request, Address $address)
//     {
//         $validatedData = $request->validate([
//             'full_name' => 'required|max:255',
//             'phone_number' => 'required',
//             'email' => 'required|email',
//             'address' => 'required',
//             'province' => 'required',
//             'city' => 'required'
//         ]);

//         $address->update($validatedData);

//         return redirect('/profile/address')->with('success', 'Address has been updated');
//     }

//     public function destroy(Address $address)
//     {
//         $address->delete();

//         return redirect('/profile/address')->with('success', 'Address has been deleted!');
//     }
// }

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $responseProvince = Http::withHeaders([
            'key' => 'acbba820fb1f76d8adff38610a3a253d'
        ])->get('https://api.rajaongkir.com/starter/province');
        $provinces = $responseProvince['rajaongkir']['results'];

        $responseCity = Http::withHeaders([
            'key' => 'acbba820fb1f76d8adff38610a3a253d'
        ])->get('https://api.rajaongkir.com/starter/city');
        $cities = $responseCity['rajaongkir']['results'];

        // Hanya ambil alamat yang terkait dengan pengguna yang sedang login
        $addresses = Address::where('user_id', $userId)->get();
        $primaryAddress = Address::where('user_id', $userId)->where('is_primary', true)->first();

        return view('profile.address.show', compact('addresses', 'primaryAddress', 'provinces', 'cities'), [
            'title' => 'address'
        ]);
    }

    public function setPrimary(Request $request, $id)
    {
        $userId = auth()->id();
        $address = Address::where('id', $id)->where('user_id', $userId)->firstOrFail();

        // Reset semua alamat ke non-primary untuk pengguna yang sedang login
        Address::where('user_id', $userId)->update(['is_primary' => false]);

        // Set alamat ini sebagai primary
        $address->is_primary = true;
        $address->save();

        return redirect()->back()->with('success', 'Alamat utama telah diperbarui.');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|max:255',
            'phone_number' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required'
        ]);

        $validatedData['user_id'] = auth()->id();
        $validatedData['province_id'] = $request->input('province');
        $validatedData['city_id'] = $request->input('city');

        Address::create($validatedData);

        return redirect('/profile/address')->with('success', 'New address has been added!');
    }

    public function show(Address $address)
    {
        // Pastikan hanya alamat milik pengguna yang ditampilkan
        $this->authorize('view', $address);

        return view('profile.address.show', [
            'title' => 'Show Address',
            'address' => $address
        ]);
    }

    public function edit(Address $address)
    {
        $this->authorize('update', $address);

        return view('profile.address.edit', [
            'address' => $address
        ]);
    }

    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validatedData = $request->validate([
            'full_name' => 'required|max:255',
            'phone_number' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required'
        ]);

        $address->update($validatedData);

        return redirect('/profile/address')->with('success', 'Address has been updated');
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();

        return redirect('/profile/address')->with('success', 'Address has been deleted!');
    }
}

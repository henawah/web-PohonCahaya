@extends('layouts.main')

@section('containers')
<div class="card shadow">
    <div class="card-body">
        <h4 class="card-title">Alamat yang Disimpan</h4>
        @foreach($addresses as $address)
        <div class="address-item mb-3">
            <p><strong>Nama:</strong> {{ $address->full_name }}</p>
            <p><strong>Nomor Telepon:</strong> {{ $address->phone_number }}</p>
            <p><strong>Email:</strong> {{ $address->email }}</p>
            <p><strong>Alamat:</strong> {{ $address->address }}, {{ $address->subdistrict }}, {{ $address->district }}, 
                {{ $address->city }}, {{ $address->province }}</p>
            <div class="mt-2">
                <a href="#" class="btn btn-sm btn-primary">Pilih</a>
                <a href="#" class="btn btn-sm btn-success">Edit</a>
                <form action="{{ route('address.destroy', $address->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">Hapus</button>
                </form>
            </div>
        </div>
        <hr>
    @endforeach
        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#tambahAlamatModal">Tambah Alamat</button>
    </div>
</div>

    
@endsection

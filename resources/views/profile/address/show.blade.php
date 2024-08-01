@extends('layouts.main')

@section('containers')
<div class="container mb-4">
    <div class="row">
        <div class="col-lg-3">
            <div class="list-group">
                <a href="/profile" class="list-group-item list-group-item-action">Profil</a>
                <a href="/profile/address" class="list-group-item list-group-item-action active">Alamat</a>
                <a href="/bank" class="list-group-item list-group-item-action">Bank & Kartu</a>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Alamat Saya</h4>
                    @foreach($addresses as $address)
                    <div class="card mb-3 {{ $address->is_primary ? 'border border-primary' : '' }}">
                        <div class="card-body">
                            <p class="card-text mb-1">{{ $address->full_name }}</p>
                            <p class="card-text mb-1">{{ $address->phone_number }}</p>
                            <p class="card-text mb-1">{{ $address->email }}</p>
                            <p class="card-text mb-1">{{ $address->address }}, {{ $address->city }}, {{ $address->province }}</p>
                            @if ($address->is_primary)
                                <span class="badge bg-primary">Alamat Utama</span>
                            @endif
                            <div class="mt-2">
                                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('address.show', $address->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">Hapus</button>
                                </form>
                                <form action="{{ route('address.primary', $address->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-check form-switch d-inline">
                                        <input class="form-check-input" type="checkbox" id="is_primary_{{ $address->id }}" name="is_primary" {{ $address->is_primary ? 'checked' : '' }} onchange="this.form.submit()">
                                        <label class="form-check-label" for="is_primary_{{ $address->id }}">Alamat Utama</label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <hr>
                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#tambahAlamatModal">Tambah Alamat</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahAlamatModal" tabindex="-1" aria-labelledby="tambahAlamatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahAlamatModalLabel">Tambah Alamat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/profile/address">
                    @csrf
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Nomor Telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Alamat" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="province" class="form-label">Provinsi</label>
                            <select name="province" id="province" class="form-select" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinces as $province)
                                <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label">Kabupaten</label>
                            <select name="city" id="city" class="form-select" required>
                                <option value="">Pilih Kabupaten</option>
                                @foreach($cities as $city)
                                <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Alamat</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

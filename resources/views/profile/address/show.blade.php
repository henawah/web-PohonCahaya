@extends('layouts.main')

@section('containers')
<div class="container text-center mb-4">
    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
      <div class="col">
          <a href="/profile">
        <div class="p-2 btn"> Profil </div></a>
      </div>
      <div class="col">
          <a href="/profile/address">
        <div class="p-2 btn"> Alamat </div></a>
      </div>
      <div class="col">
          <a href="/bank">
        <div class="p-2 btn"> Bank & Kartu </div></a>
      </div>
    </div>
  </div>
<div class="card shadow">
    <div class="card-body">
        <h4 class="card-title">Alamat Saya</h4>
        @foreach($addresses as $address)
        <div class="address-item mb-3">
            <br>{{ $address->full_name }} | {{ $address->phone_number }}
            <br>{{ $address->email }}
            <br>{{ $address->address }}, {{ $address->subdistrict }}, {{ $address->district }}, 
                {{ $address->city }}, {{ $address->province }}</p>
            <div class="mt-2">
                <a href="#" class="btn btn-sm ">Edit</a>
                <form action="{{ route('address.show', $address->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm " onclick="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">Hapus</button>
                </form>
            </div>
        </div>
        <hr>
    @endforeach
        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#tambahAlamatModal">Tambah Alamat</button>
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
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Nama Lengkap" required>
                                <label for="full_name">Nama Lengkap</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Nomor Telepon" required>
                                <label for="phone_number">Nomor Telepon</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                <label for="email">Email address</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Alamat" required>
                                <label for="address">Alamat</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="province" name="province" required>
                                    <option selected disabled>Pilih Provinsi</option>
                                    <option value="1">Provinsi 1</option>
                                    <option value="2">Provinsi 2</option>
                                    <option value="3">Provinsi 3</option>
                                </select>
                                <label for="province">Provinsi</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="city" name="city" required>
                                    <option selected disabled>Pilih Kota</option>
                                    <option value="1">Kota 1</option>
                                    <option value="2">Kota 2</option>
                                    <option value="3">Kota 3</option>
                                </select>
                                <label for="city">Kota</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="district" name="district" required>
                                    <option selected disabled>Pilih Kecamatan</option>
                                    <option value="1">Kecamatan 1</option>
                                    <option value="2">Kecamatan 2</option>
                                    <option value="3">Kecamatan 3</option>
                                </select>
                                <label for="district">Kecamatan</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="subdistrict" name="subdistrict" required>
                                    <option selected disabled>Pilih Kelurahan</option>
                                    <option value="1">Kelurahan 1</option>
                                    <option value="2">Kelurahan 2</option>
                                    <option value="3">Kelurahan 3</option>
                                </select>
                                <label for="subdistrict">Kelurahan</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Simpan Alamat</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
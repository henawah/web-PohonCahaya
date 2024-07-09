@extends('layouts.main')

@section('containers')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <!-- Form untuk input alamat -->
        </div>

        <div class="col-lg-6">
            <div class="card mb-9 shadow mt-3">
                <div class="card-body">
                    <h4 class="card-title">Alamat yang Telah Disimpan</h4>
                    @if(session('alamat'))
                        @foreach(session('alamat') as $key => $alamat)
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h5 class="card-title">Alamat {{ $key + 1 }}</h5>
                                    <p class="card-text">
                                        <strong>Nama Lengkap:</strong> {{ $alamat['nama_lengkap'] }} <br>
                                        <strong>Nomor Telepon:</strong> {{ $alamat['nomor_telepon'] }} <br>
                                        <strong>Email:</strong> {{ $alamat['email'] }} <br>
                                        <strong>Alamat:</strong> {{ $alamat['alamat'] }} <br>
                                        <strong>Provinsi:</strong> {{ $alamat['provinsi'] }} <br>
                                        <strong>Kota:</strong> {{ $alamat['kota'] }} <br>
                                        <strong>Kecamatan:</strong> {{ $alamat['kecamatan'] }} <br>
                                        <strong>Kelurahan:</strong> {{ $alamat['kelurahan'] }} <br>
                                    </p>
                                    <a href="#" class="btn btn-primary btn-sm">Ubah Alamat</a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Belum ada alamat yang disimpan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
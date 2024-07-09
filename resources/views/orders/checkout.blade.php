{{-- @extends('layouts.main')

@section('containers')
@if(session()->has('success'))
    <div class="alert alert-success col-lg-10" role="alert">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-3 mb-3 mb-sm-0 mt-3">
                <div class="card ">
                    @if($addresses->isNotEmpty())
                        <h4 class="card-title">Alamat yang Disimpan</h4>
                        @foreach($addresses as $address)
                            <p>
                                {{ $address->full_name }}
                                {{ $address->phone_number }}
                                {{ $address->email }}
                                {{ $address->address }}
                                {{ $address->province }}
                                {{ $address->city }}
                                {{ $address->district }}
                                {{ $address->subdistrict }}
                            </p>
                            <hr>
                        @endforeach
            @else
                <p>Belum ada alamat yang ditambahkan.</p>
            @endif
                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#tambahAlamatModal">Tambah Alamat</button>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-9 shadow mt-3">
                <div class="card-body">
                    <h4 class="card-title">Pembayaran</h4>
                    @foreach($posts as $post)
                        <div class="row g-0">
                            <div class="col-md-2 mt-2 me-2">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded-start" alt="{{ $post->title }}">
                                @else
                                    <img src="https://source.unsplash.com/200x200?{{ $post->category->name }}" class="img-fluid rounded-start" alt="{{ $post->title }}">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text">Rp. {{ number_format($post->price) }}</p>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg">Bayar</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Alamat -->
<div class="modal fade" id="tambahAlamatModal" tabindex="-1" aria-labelledby="tambahAlamatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahAlamatModalLabel">Tambah Alamat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/orders/checkout">
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
@endsection --}}

@extends('layouts.main')

@section('containers')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">
            @if (empty($cart))
                <div class="alert alert-info" role="alert">
                    {{ $message }}
                </div>
            @else
                @foreach ($posts as $post)
                    <div class="post card mb-3 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-3 p-3">
                                <input class="form-check-input" type="checkbox" value="{{ $post->id }}" id="checkbox{{ $post->id }}" onclick="updateTotal()">
                                <label class="form-check-label" for="checkbox{{ $post->id }}"></label>
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded-start" alt="{{ $post->title }}">
                                @else
                                    <img src="https://source.unsplash.com/200x200?{{ $post->category->name }}" class="img-fluid rounded-start" alt="{{ $post->title }}">
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text">Rp. {{ number_format($post->price) }}</p>
                                    <p class="card-text">Stock: <span id="stock{{ $post->id }}">{{ $post->stock }}</span></p>
                                    <div class="quantity-controls">
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1 px-2 py-0" onclick="decreaseStock('{{ $post->id }}')">-</button>
                                        <span id="quantity{{ $post->id }}" class="m-2">0</span>
                                        <button type="button" class="btn btn-sm btn-outline-primary px-2 py-0" onclick="increaseStock('{{ $post->id }}')">+</button>
                                        <a href="/cart">
                                            <button type="button" class="btn btn-sm btn-outline-danger px-2 py-0" onclick="return confirm('Are You Sure?')"><i class="bi bi-trash3"></i></button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-lg-4">
            <div class="post card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Alamat Pengiriman</h5>
                    @if (session('selected_address'))
                        @php $address = session('selected_address'); @endphp
                        <p><strong>Nama:</strong> {{ $address->full_name }}</p>
                        <p><strong>Nomor Telepon:</strong> {{ $address->phone_number }}</p>
                        <p><strong>Email:</strong> {{ $address->email }}</p>
                        <p><strong>Alamat:</strong> {{ $address->address }}, {{ $address->subdistrict }}, {{ $address->district }}, 
                            {{ $address->city }}, {{ $address->province }}</p>
                    @else
                        <p>Tidak ada alamat pengiriman yang dipilih.</p>
                    @endif
                    <a href="/profile/address" class="btn btn-primary mt-3">Pilih Alamat</a>
                </div>
            </div>
            <div class="post card mb-6 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Rincian Belanja</h5>
                    <ul id="checkoutList" class="list-group mb-3">
                        @if (!empty($cart))
                            @foreach ($posts as $post)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $post->title }}
                                    <span>{{ $cart[$post->id]['quantity'] }} x Rp. {{ number_format($post->price) }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <p class="card-text">Total Harga: Rp. <span id="totalPrice">0</span></p>
                    <a href="{{ route('orders.checkout') }}" class="btn btn-primary btn-lg d-flex justify-content-between align-items-center">
                        Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function updateTotal() {
        let totalPrice = 0;
        document.querySelectorAll('.form-check-input:checked').forEach(checkbox => {
            const postId = checkbox.value;
            const quantity = parseInt(document.getElementById(`quantity${postId}`).textContent);
            const price = parseFloat(document.getElementById(`price${postId}`).textContent.replace(/\./g, ''));
            totalPrice += quantity * price;
        });
        document.getElementById('totalPrice').textContent = totalPrice.toLocaleString();
    }

    function increaseStock(postId) {
        const stockElement = document.getElementById(`stock${postId}`);
        const quantityElement = document.getElementById(`quantity${postId}`);
        let stock = parseInt(stockElement.textContent);
        let quantity = parseInt(quantityElement.textContent);
        if (stock > 0) {
            stockElement.textContent = stock - 1;
            quantityElement.textContent = quantity + 1;
        }
        updateTotal();
    }

    function decreaseStock(postId) {
        const stockElement = document.getElementById(`stock${postId}`);
        const quantityElement = document.getElementById(`quantity${postId}`);
        let stock = parseInt(stockElement.textContent);
        let quantity = parseInt(quantityElement.textContent);
        if (quantity > 0) {
            stockElement.textContent = stock + 1;
            quantityElement.textContent = quantity - 1;
        }
        updateTotal();
    }
</script>


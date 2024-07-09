{{-- @extends('layouts.main')

@section('containers')
<script src="{{ asset('js/cart.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            @if (empty($cart))
                <div class="alert alert-info" role="alert">
                    {{ $message }}
                </div>
            @else
                @foreach ($posts as $post)
                    <div class="post card mb-3 shadow">
                        <div class="row g-0">
                            <div class="col-md-2 me-2">
                                <input class="form-check-input" type="checkbox" value="{{ $post->id }}" id="checkbox{{ $post->id }}" onclick="updateTotal()">
                                <label class="form-check-label" for="checkbox{{ $post->id }}"></label>
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
                                    <p class="card-text">Stock: <span id="stock{{ $post->id }}">{{ $post->stock }}</span></p>
                                    <div class="quantity-controls">
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1 px-2 py-0" onclick="decreaseStock('{{ $post->id }}')">-</button>
                                        <span id="quantity{{ $post->id }}" class="m-2">0</span>
                                        <button type="button" class="btn btn-sm btn-outline-primary px-2 py-0" onclick="increaseStock('{{ $post->id }}')">+</button>
                                        <a href="/cart">
                                          <button type="button" class="btn btn-sm" onclick="return confirm('Are You Sure?')"><i class="bi bi-trash3"></i></button>
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
            <div class="post card mb-6 shadow">
                <div class="card-body">
                    <p class="card-text">Rincian Belanja</p>
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
                    <a href="{{ route('orders.checkout') }}" class="btn btn-first btn-lg d-flex justify-content-between align-items-center">
                        <span class="btn btn-primary">Pembayaran</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


@extends('layouts.main')

@section('containers')
<script src="{{ asset('js/cart.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            @if (empty($cart))
                <div class="alert alert-info" role="alert">
                    {{ $message }}
                </div>
            @else
                @foreach ($posts as $post)
                    <div class="post card mb-3 shadow">
                        <div class="row g-0">
                            <div class="col-md-2 me-2">
                                <input class="form-check-input" type="checkbox" value="{{ $post->id }}" id="checkbox{{ $post->id }}" onclick="updateTotal()">
                                <label class="form-check-label" for="checkbox{{ $post->id }}"></label>
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
                                    <p class="card-text">Stock: <span id="stock{{ $post->id }}">{{ $post->stock }}</span></p>
                                    <div class="quantity-controls">
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1 px-2 py-0" onclick="decreaseStock('{{ $post->id }}')">-</button>
                                        <span id="quantity{{ $post->id }}" class="m-2">{{ $cart[$post->id]['quantity'] }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-primary px-2 py-0" onclick="increaseStock('{{ $post->id }}')">+</button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteCartItem('{{ $post->id }}')">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-lg-4">
            <div class="post card mb-6 shadow">
                <div class="card-body">
                    <p class="card-text">Rincian Belanja</p>
                    <ul id="checkoutList" class="list-group mb-3">
                        @foreach ($posts as $post)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $post->title }}
                                <span>{{ $cart[$post->id]['quantity'] }} x Rp. {{ number_format($post->price) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="card-text">Total Harga: Rp. <span id="totalPrice">0</span></p>
                    <a href="{{ route('orders.checkout') }}" class="btn btn-first btn-lg d-flex justify-content-between align-items-center">
                        <span class="btn btn-primary">Pembayaran</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteCartItem(postId) {
        // Kirim permintaan AJAX untuk menghapus item dari cart
        fetch(`/cart/delete/${postId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Refresh halaman atau perbarui data setelah penghapusan berhasil
                location.reload(); // Contoh: reload halaman untuk perbarui data
            } else {
                alert('Gagal menghapus item dari keranjang.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus item dari keranjang.');
        });
    }
</script>

@endsection

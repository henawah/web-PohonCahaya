@extends('layouts.main')

@section('containers')

@if (@session()->has('success'))
    <div class="alert alert-success col-lg-10" role="alert">
        {{ session('success') }}
    </div>
    
@endif

<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <form action="/posts" method="GET" id="categoryForm">
                <div class="list-group mb-3 d-none d-lg-block">
                    <a href="/posts" class="list-group-item list-group-item-action {{ request('category') ? '' : 'active' }}">
                        All Categories
                    </a>
                    @foreach ($categories as $category)
                        <div class="form-check">
                            <a href="/posts?category={{ $category->slug }}">
                            <input class="form-check-input" type="radio" name="category" value="{{ $category->slug }}" id="category_{{ $category->id }}" {{ request('category') == $category->slug ? 'checked' : '' }} onchange="this.form.submit()"> 
                            <label class="form-check-label">{{ $category->name }}</label>
                            </a>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>

        <div class="col-lg-9">
            @if ($posts->isNotEmpty())
                <div class="row">
                    <div class="col-sm-10">
                        <div class="card mb-3 shadow">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    @if ($post->image)
                                    <div style=" overflow:hidden">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}"
                                        class="img-fluid mt-3"> 
                                    </div>
                                    @else 
                                    <img src="https://source.unplash.com/1200x400?{{ 
                                    $post->category->name }}" alt="{{ $post->category->name }}"
                                    class="img-fluid mt-3">  
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="card-text"><small class="text-muted">{{ $post->created_at->diffForHumans() }}</small></p>
                                        <a href="/posts?category={{ $post->category->slug }}" class="text-decoration-none">{{ $post->category->name }}</a></p>
                                        {!! $post->excerpt !!}
                                        <p class="card-text">Rp. {{ number_format($post->price) }}</p>
                                        <p class="card-text">Stock: <span id="stock{{ $post->id }}">{{ $post->stock }}</span></p>
                                        <div class="quantity-controls">
                                            <button type="button" class="btn btn-sm btn-outline-primary me-1 px-2 py-0" onclick="decreaseStock('{{ $post->id }}')">-</button>
                                            <span id="quantity{{ $post->id }}" class="m-2"> 0 </span>
                                            <button type="button" class="btn btn-sm btn-outline-primary px-2 py-0" onclick="increaseStock('{{ $post->id }}')">+</button>
                                        </div>
                                    </div>
                                    <form action="{{ route('cart.add', ['postId' => $post->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="submit" class="btn btn-primary" value="Keranjang">
                                    </form>                                    
                                    <form action="/orders/checkout" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $post->slug }}" name="slug">
                                        <input type="submit" class="btn btn-warning" value="Beli Sekarang">
                                    </form>
                                                                                                 
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 shadow">
                            <div class="card-body">
                                <p>{!! $post->body !!}</p>
                            </div>
                        </div>

                        <div class="row">
                            @foreach ($posts->skip(1) as $post)
                            <div class="col-md-4 col-6 mt-2">
                                <div class="card">
                                    <a href="/posts/{{ $post->slug }}" class="text-decoration-none text-dark">
                                        @if ($post->image)
                                        <div style="max-height: 350px; overflow:hidden">
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}"
                                            class="img-fluid mt-3"> 
                                        </div>
                                        @else 
                                        <img src="https://source.unsplash.com/200x200?{{ $post->category->name }}" class="card-img-top" alt="{{ $post->category->name }}">
                                        @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="card-text">Rp. {{ number_format($post->price) }}</p>
                                    </div>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            @else
                <p>No posts available.</p>
            @endif
        </div>
    </div>
</div>
<script>
    function decreaseStock(postId) {
        let quantityElement = document.getElementById('quantity' + postId);
        let stockElement = document.getElementById('stock' + postId);
        let currentQuantity = parseInt(quantityElement.textContent);
        let stock = parseInt(stockElement.textContent);

        if (currentQuantity > 0) {
            currentQuantity--;
            stock++;
            quantityElement.textContent = currentQuantity;
            stockElement.textContent = stock;
        }
    }

    function increaseStock(postId) {
        let quantityElement = document.getElementById('quantity' + postId);
        let stockElement = document.getElementById('stock' + postId);
        let currentQuantity = parseInt(quantityElement.textContent);
        let stock = parseInt(stockElement.textContent);

        // Di sini Anda mungkin ingin memeriksa batasan stok sebelum menambah
        // Misalnya, Anda bisa menambahkan validasi jika stok masih tersedia
        if (stock > 0) {
            currentQuantity++;
            stock--;
            quantityElement.textContent = currentQuantity;
            stockElement.textContent = stock;
        }
    }
    // Menggunakan event delegation untuk menangani klik tombol "Keranjang"
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('addToCartButton')) {
            e.preventDefault();
            let postId = e.target.getAttribute('data-post-id');
            let form = document.getElementById('addToCartForm_' + postId);
            form.submit();
        }
    });
</script>

@endsection

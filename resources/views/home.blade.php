@extends('layouts.main')

@section('containers')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<nav>
  <div class="carousel slide" id="carouselExample" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/ch1.png" class="d-block w-100" alt="Buku 1">
      </div>
      <div class="carousel-item">
        <img src="assets/ch2.png" class="d-block w-100" alt="Buku 2">
      </div>
      <div class="carousel-item">
        <img src="assets/ch3.jpg" class="d-block w-100" alt="Buku 3">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon custom-carousel-control" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon custom-carousel-control" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</nav>

<div class="container mt-5 bg-light p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kategori</h2>
    <a href="/posts" class="btn btn-primary">Lihat Semua</a>
  </div>
  <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      @foreach ($categories->chunk(5) as $categoryChunk)
        <div class="carousel-item @if($loop->first) active @endif">
          <div class="row justify-content-center">
            @foreach ($categoryChunk as $category)
              <div class="col-md-2 col-sm-4 col-6 mb-4">
                <div class="card h-100 shadow-sm">
                  <a href="/posts?category={{ $category->slug }}" class="stretched-link black">
                    @if ($category->image)
                      <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top img-fluid" alt="{{ $category->name }}">
                    @else
                      <img src="https://source.unsplash.com/200x200?{{ $category->name }}" class="card-img-top img-fluid" alt="{{ $category->name }}">
                    @endif
                  </a>
                  <div class="card-body text-center">
                    <p class="card-title">{{ $category->name }}</p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#categoryCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon custom-carousel-control" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#categoryCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon custom-carousel-control" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>

<div class="container mt-5 bg-light p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Buku Terbaru</h2>
    <a href="/posts" class="btn btn-primary">Lihat Semua</a>
  </div>
  <div class="row">
    @if ($posts->isNotEmpty())
      @foreach ($posts as $post)
        <div class="col-md-2 col-sm-4 col-6 mb-4">
          <div class="card h-100 shadow-sm">
            <a href="/posts/{{ $post->slug }}" class="stretched-link text-decoration-none text-dark">
              @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top img-fluid" alt="{{ $post->category->name }}">
              @else
                <img src="https://source.unsplash.com/200x200?{{ $post->category->name }}" class="card-img-top img-fluid" alt="{{ $post->category->name }}">
              @endif
              <div class="card-body">
                <p class="card-title text-break">{{ $post->title }}</p>
                <p class="card-text">Rp. {{ number_format($post->price) }}</p>
              </div>
              
            </a>
          </div>
        </div>
      @endforeach
    @else
      <p class="text-center">Tidak ada buku yang tersedia saat ini.</p>
    @endif
  </div>
</div>
@endsection

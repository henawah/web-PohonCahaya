@extends('layouts.main')

@section('containers')
<nav>
  <div class="corousel ">
    <div id="carouselExample" class="carousel slide">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="assets/ch1.png" class="d-block w-100 h-50" alt="Buku 1">
        </div>
        <div class="carousel-item">
          <img src="assets/ch2.png" class="d-block w-100 h-50" alt="Buku 2">
        </div>
        <div class="carousel-item">
          <img src="assets/ch3.jpg" class="d-block w-100 h-50" alt="Buku 3">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</nav>

<div class="container">
  <div class="row">
    <div class="selector mt-4">
      <a href="/posts">Kategori</a>
    </div>
    @foreach ($categories as $category)
      <div class="col-md-2 col-sm-6 col-16">
        <a href="/posts?category={{ $category->slug }}">
          {{-- <div class="card"> --}}
            @if ($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid mt-3">
                    @else
                    <img src="https://source.unsplash.com/200x200?{{ $category->name }}" class="card-img-top" alt="{{ $category->name }}">
                    @endif
            {{-- <div class="card-img-overlay d-flex align-items-center p-0">
              <h5 class="card-title text-center flex-fill" style="background-color: rgba(0, 0, 0, 0.3)">{{ $category->name }}</h5>
            </div> --}}
          {{-- </div> --}}
        </a>
      </div>
    @endforeach
    <div class="col-12 mt-4 d-md-none">
      <a href="/posts">Selengkapnya</a>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="selector mt-4">
      <a href="/posts">Buku Terbaru</a>
    </div>
    @if ($posts->isNotEmpty())
      @foreach ($posts as $post)
        <div class="col-md-2 col-sm-6 col-6 mt-4">
          <div class="card">
            <a href="/posts/{{ $post->slug }}" class="text-decoration-none text-dark">
              <div class="card text-dark">
                @if ($post->image)
                <div style="max-height: 350px; overflow:hidden">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}"
                    class="img-fluid mt-3"> 
                </div>
                @else 
                <img src="https://source.unsplash.com/300x200?{{ $post->category->name }}" class="card-img" alt="{{ $post->category->name }}"> 
                @endif
                
                <div class="card-body">
                  <h5 class="card-title">{{ $post->title }}</h5>
                  <p>Rp. {{ number_format($post->price) }}</p>
                </div>
              </div>
            </a>
          </div>
        </div>
      @endforeach
    @else
      <p class="text-center">Tidak ada buku yang tersedia saat ini.</p>
    @endif
    <div class="col-12 mt-4 d-md-none">
      <a href="/posts">Selengkapnya</a>
    </div>
  </div>
</div>
@endsection

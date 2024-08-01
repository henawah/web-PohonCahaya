@extends('layouts.main')

@section('containers')
@if ($posts->count())
<div class="container">
    <div class="row">
        <div class="col-lg-3 bg-light">
            <form action="/posts" method="GET" id="categoryForm">
                <div class="list-group mb-3 d-none d-lg-block">
                    <h4 class="card-title mb-3 mt-3">Categories</h4>
                    @foreach ($categories as $category)
                        <div class="form-check">
                            <a href="/posts?category={{ $category->slug }}">
                            <input class="form-check-input" type="radio" name="category" value="{{ $category->slug }}" id="category_{{ $category->id }}" {{ request('category') == $category->slug ? 'checked' : '' }} onchange="this.form.submit()"> 
                            <label class="form-check-label "><h7 class="text-black" style="font-weight: 300">{{ $category->name }}</h7></label>
                            </a>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4 col-sm-6 col-6 mt-2">
                        <div class="card h-100 shadow-sm">
                            <a href="/posts/{{ $post->slug }}" class="text-decoration-none text-dark">
                                @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}"
                                    class="img-fluid mt-3"> 
                                @else 
                                <img src="https://source.unsplash.com/200x200?{{ $post->category->name }}" class="card-img-top" alt="{{ $post->category->name }}"> 
                                @endif
                           
                            <div class="card-body">
                                    <p class="card-title">{{ $post->title }}</p>
                                    <p class="card-text">Rp. {{ number_format($post->price) }}</p>
                            </div>
                        </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@else
  <p class="text-center fs-4">Tidak ada hasil yang sesuai</p>  
@endif


@endsection

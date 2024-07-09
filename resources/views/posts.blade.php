@extends('layouts.main')

@section('containers')
@if ($posts->count())
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
        <div class="col-lg-9 mb-3">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4 col-sm-6 col-6 mt-2">
                        <div class="card">
                            <a href="/posts/{{ $post->slug }}" class="text-decoration-none text-dark">
                                @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}"
                                    class="img-fluid mt-3"> 
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

@extends('layouts.main')

@section('containers')
<div class="container">
    <div class="row">
        @foreach ($categories as $category)
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
                <h5 class="card-title">{{ $category->name }}</h5>
              </div>
            </div>
          </div>
        @endforeach
    </div>
</div>
@endsection

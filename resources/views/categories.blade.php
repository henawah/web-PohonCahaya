{{-- @extends('layouts.main')

@section('containers')
<div class="containe">
    <div class="row">
        @foreach ($categories as $category)
        <div class="col-md-4 mt-4">
            <a href="/posts?category={{ $category->slug }}">
            <div class="card bg-dark text-white">
                @if ($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                    class="img-fluid mt-3"> 
                @else 
                <img src="https://source.unsplash.com/200x200?{{ $category->name }}" class="card-img-top" alt="{{ $category->name }}"> 
                @endif
                <div class="card-img-overlay d-flex align-items-center p-0" >
                    <h5 class="card-title text center flex-fill" style="background-color: rgba(0, 0, 0, 0.3)">{{ $category->name }}</h5>
                    </div>
                </div>
            </a>
            </div>
            @endforeach
        </div>
</div>

@endsection --}}
@extends('layouts.main')

@section('containers')
<div class="container">
    <div class="row">
        @foreach ($categories as $category)
        <div class="col-md-4 mt-4">
            <a href="/posts?category={{ $category->slug }}">
                <div class="card bg-dark text-white">
                    @if ($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid mt-3">
                    @else
                    <img src="https://source.unsplash.com/200x200?{{ $category->name }}" class="card-img-top" alt="{{ $category->name }}">
                    @endif
                    <div class="card-img-overlay d-flex align-items-center p-0">
                        <h5 class="card-title text-center flex-fill" style="background-color: rgba(0, 0, 0, 0.3)">{{ $category->name }}</h5>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection

@extends('layouts.main')

@section('containers')
<div class="container">
    <div class="row">
        @foreach ($articles as $article)
        <div class="col-sm-10">
          <div class="card mb-3 shadow">
            <div class="col-md-8">
              <div class="card-body">
                  <h5 class="card-title">{{ $article->name }}</h5>
                  <p class="card-text"><small class="text-muted">{{ $article->created_at->diffForHumans() }}</small></p>
              </div>
            </div>
            <div class="col-md-4 me-4">
                      @if ($article->image)
                      <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->name }}">
                      @else
                      <img src="https://source.unsplash.com/1200x400" class="card-img-top" alt="{{ $article->name }}">
                      @endif
                    </div>
                    <div class="card-body">
                      {!! $article->excerpt !!}
                      <a href="/articles">Read More...</a>
                    </div>

          </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

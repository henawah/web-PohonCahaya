<link href="{{ asset('style.css') }}" rel="stylesheet">
<nav class="navbar navbar-expand-lg bg-body-primary">
  <div class="container">
    <a class="navbar-brand" href="/">
      <img src="{{ asset('assets/logoPC.png') }}" width="70" height="70" alt="Logo PT. Pohon Cahaya">
    </a>
    <span class="navbar-brand text-white me-auto">PT. Pohon Cahaya</span>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link {{ ($title === 'Home') ? 'active' : '' }} text-white" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ ($title === 'About') ? 'active' : '' }} text-white" href="/about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ ($title === 'Article') ? 'active' : '' }} text-white" href="/article">Article</a>
        </li>
        <li class="nav-item dropdown d-lg-none">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach ($categories as $category)
              <li><a class="dropdown-item" href="/posts?category={{ $category->slug }}">{{ $category->name }}</a></li>
            @endforeach
          </ul>
        </li>      
      </ul>
      
      <form action="/posts" class="d-flex mb-1">
        @if (request('category'))
          <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        @if (request('author'))
          <input type="hidden" name="author" value="{{ request('author') }}">
        @endif
        <div class="input-group me-auto">
          <input type="text" class="form-control" placeholder="Cari Judul Buku, Penulis" name="search" value="{{ request('search') }}">
          <button class="btn btn-white text-white" type="submit">Search</button>
        </div>
      </form>

      <div class="navbar-icons d-flex align-items-center mb-1"  style="width: 15%;">
        <a href="/cart" class="me-3 {{ ($title == 'Shop') ? 'active' : '' }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-cart4" viewBox="0 0 16 16">
            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 
            0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 
            1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
          </svg>
        </a>
        <ul class="navbar-nav ms-auto text-white">
          @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu">
              @can('admin')
              <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
              <li><hr class="dropdown-divider"></li>
              @endcan
              <li><a class="dropdown-item" href="/profile"><i class="bi bi-person-fill"></i> Profile </a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
              <form action="/logout" method="post">
                @csrf
                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-in-right"></i> Logout</button>
              </form>
              </li>
            </ul>
          </li>
          @else
          <a href="/login" class="{{ ($title == 'Login') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="16" fill="white" class="bi bi-person-fill" viewBox="0 0 16 16">
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
            </svg>
          </a>
        @endauth
      </ul>
      </div>
    </div>
  </div>
</nav>

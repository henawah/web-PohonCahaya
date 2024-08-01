@extends('layouts.main')
@section('containers')

<div class="row justify-content-center">
    <div class="col-lg-4">
      @if (session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>
      @endif
      @if (session()->has('loginError'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('loginError') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>
      @endif

        <main class="form-signin bg-light">
            <h1 class="h3 mb-3 fw-normal text-center mt-4">Please Login</h1>
            <form action="/login" method="post">
              @csrf          
              <div class="form-floating">
                <input type="email" name="email" class="form-control @error('email') is-invalid                  
                @enderror" id="email"
                 placeholder="name@example.com" autofocus required value="{{ old('email') }}">
                 <label for="floatingInput">Email address</label>
                 @error('email')
                   <div class="invalid-feedback">
                    {{ $message }}
                   </div>
                 @enderror
              </div>
              <div class="form-floating">
                <input type="password" name="password" class="form-control" id="password" 
                placeholder="Password" required>
                <label for="floatingPassword">Password</label>
              </div>
              <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
            </form>
            <h6 class="mt-4 mb-4 text-center">--------------OR--------------</h6>
            <div class="social-auth-links text-center mt-2 mb-3 ">
              <a href="{{ route('google.redirect') }}" class="btn btn-block w-100 py-2 btn-primary">
                <i class="bi bi-google"></i> Sign in using Google
              </a>
            </div>
            <small class="d-block text-center mt-3">Not register? <a href="/register">Register Now!</a></small>
          </main>
    </div>
</div>

@endsection
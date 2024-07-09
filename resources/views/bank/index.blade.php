@extends('layouts.main')

@section('containers')
<div class="container text-center mb-4">
    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
      <div class="col">
          <a href="/profile">
        <div class="p-2 btn"> Profil </div></a>
      </div>
      <div class="col">
          <a href="/address">
        <div class="p-2 btn"> Alamat </div></a>
      </div>
      <div class="col">
          <a href="/bank">
        <div class="p-2 btn"> Bank & Kartu </div></a>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <form action="{{ route('profile.update') }}" method="post">
        @csrf
        <div class="row mb-3">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="username" name="username" value="{{ old('username', Auth::user()->username) }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="inputEmail3" name="email" value="{{ old('email', Auth::user()->email) }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="phone_number" class="col-sm-2 col-form-label">Nomor Telepon</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', Auth::user()->profile->phone_number ?? '') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
  </div>
@endsection

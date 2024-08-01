@extends('layouts.main')

@section('containers')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-3">
            <div class="list-group">
                <a href="/profile" class="list-group-item list-group-item-action active">Profil</a>
                <a href="/profile/address" class="list-group-item list-group-item-action">Alamat</a>
                <a href="/bank" class="list-group-item list-group-item-action">Bank & Kartu</a>
            </div>
        </div>
        <div class="col-lg-9">
            <form action="/profile" method="post">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username', Auth::user()->username) }}">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}">
                </div>
                <div class="mb-3">
                    <label for="inputEmail3" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail3" name="email" value="{{ old('email', Auth::user()->email) }}">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
@endsection

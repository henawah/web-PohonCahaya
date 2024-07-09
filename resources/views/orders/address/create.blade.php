@extends('layouts.main')

@section('containers')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form method="POST" action="/orders/checkout">
                @csrf
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control" id="floatingInputGrid" >
                            <label for="floatingInputGrid">Nama Lengkap</label>
                          </div>
                          <div class="form-floating mt-5">
                            <input type="text" class="form-control" id="floatingInputGrid" >
                            <label for="floatingInputGrid">Nomor telepon</label>
                          </div>
                      <div class="form-floating mt-5">
                        <input type="email" class="form-control" id="floatingInputGrid" >
                        <label for="floatingInputGrid">Email address</label>
                      </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="floatingInputGrid" >
                        <label for="floatingInputGrid">Alamat</label>
                      </div>
                      <div class="form-floating mt-5">
                        <select class="form-select" id="floatingSelectGrid">
                          <option selected>provinsi</option>
                        </select>
                        <label for="floatingSelectGrid">provinsi</label>
                      </div>
                      <div class="form-floating mt-5">
                        <select class="form-select" id="floatingSelectGrid">
                          <option selected>Kota</option>
                        </select>
                        <label for="floatingSelectGrid">Kota</label>
                      </div>
                      <div class="form-floating mt-5">
                        <select class="form-select" id="floatingSelectGrid">
                          <option selected>Kecamatan</option>
                        </select>
                        <label for="floatingSelectGrid">Kecamatan</label>
                      </div>
                      <div class="form-floating mt-5">
                        <select class="form-select" id="floatingSelectGrid">
                          <option selected>kelurahan</option>
                        </select>
                        <label for="floatingSelectGrid">kelurahan</label>
                      </div>
                      <button type="submit" class="btn btn-primary btn-lg mt-3" >Simpan</button>
                    </div>
                  </div>
            </form>
        </div>
    </div>
</div>
@endsection
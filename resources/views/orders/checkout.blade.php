@extends('layouts.main')

@section('containers')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Alamat Pengiriman</h5>
                    @if ($primaryAddress)
                        <p><strong>Nama:</strong> {{ $primaryAddress->full_name }}</p>
                        <p><strong>Nomor Telepon:</strong> {{ $primaryAddress->phone_number }}</p>
                        <p><strong>Email:</strong> {{ $primaryAddress->email }}</p>
                        <p><strong>Alamat:</strong> {{ $primaryAddress->address }}, {{ $primaryAddress->city }}, {{ $primaryAddress->province }}</p>
                    @else
                        <p>Tidak ada alamat pengiriman yang dipilih.</p>
                    @endif
                    <a href="/profile/address" class="btn btn-primary mt-3">Pilih Alamat</a>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <form id="cekOngkirForm" action="{{ route('orders.checkongkir') }}" method="post">
                @csrf
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Cek Ongkir</h5>
                        <div class="form-group">
                            <label for="destination">Kota Tujuan</label>
                            <select name="destination" id="destination" class="form-control" required>
                                @if ($primaryAddress)
                                    <option value="{{ $primaryAddress->city }}">{{ $primaryAddress->city }}</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                                    @endforeach
                                @else
                                    <option value="">Pilih alamat terlebih dahulu</option>
                                @endif
                            </select>
                        </div>
                        <h5 class="card-title">Rincian Belanja</h5>
                        <ul id="checkoutList" class="list-group mb-3">
                            @foreach ($posts as $post)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $post->title }}
                                    <span>{{ $cart[$post->id]['quantity'] }} x Rp. {{ number_format($post->price) }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="card-text">Total Harga: Rp. <span id="totalPrice">{{ $totalPrice }}</span></p>
                        <div class="form-group">
                            <label for="weight">Berat Paket (gram)</label>
                            <input type="number" name="weight" id="weight" class="form-control" value="{{ $totalWeight }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="courier">Pilih Kurir</label>
                            <select name="courier" id="courier" class="form-control" required>
                                <option value="">Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Cek Ongkir</button>
                    </div>
                </div>
            </form>
            <div id="ongkirDetails" class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Rincian Ongkir</h5>
                    @if($ongkir && isset($ongkir['origin_details']))
                        <ul>
                            <li>Asal Kota: {{ $ongkir['origin_details']['city_name'] }}</li>
                            <li>Kota Tujuan: {{ $ongkir['destination_details']['city_name'] }}</li>
                            <li>Berat Paket: {{ $ongkir['query']['weight'] }} gram</li>
                        </ul>
                        @foreach ($ongkir['results'] as $item)
                            <div>
                                <strong>{{ $item['name'] }}</strong>
                                <div class="form-check">
                                    @foreach($item['costs'] as $cost)
                                        <input class="form-check-input" type="radio" name="shipping_service" id="shipping_service_{{ $cost['service'] }}" value="{{ $cost['service'] }}" required>
                                        <label class="form-check-label" for="shipping_service_{{ $cost['service'] }}">
                                            {{ $cost['service'] }} - Rp. {{ number_format($cost['cost'][0]['value']) }} (Estimasi: {{ $cost['cost'][0]['etd'] }} hari)
                                        </label>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <form action="{{ route('orders.checkout') }}" method="POST">
                            @csrf
                            
                            <hr>
                            <h5 class="card-title">Total Belanja + Ongkir</h5>
                            <p class="card-text">Total Harga: Rp. <span id="totalPrice">{{ $totalPrice }}</span></p>
                            <p class="card-text">Total Ongkir: Rp. <span id="totalOngkir">{{ $ongkir['results'][0]['costs'][0]['cost'][0]['value'] }}</span></p>
                            <p class="card-text">Total Bayar: Rp. <span id="totalBayar">{{ $totalPrice + $ongkir['results'][0]['costs'][0]['cost'][0]['value'] }}</span></p>
                        </form>
                    @else
                        <p>Masukkan data untuk melihat ongkir.</p>
                    @endif
                </div>
            </div>
            <div class="card">
                <button id="pay-button" class="btn btn-primary">Buat Pesanan</button>
            </div>
        </div>
    </div>
</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                // Redirect to the callback route with the order ID
                window.location.href = "{{ route('orders.callback') }}?order_id=" + result.order_id;
            },
            onPending: function (result) {
                alert("waiting for your payment!"); console.log(result);
            },
            onError: function (result) {
                alert("payment failed!"); console.log(result);
            },
            onClose: function () {
                alert('you closed the popup without finishing the payment');
            }
        });
    });
</script>
@endsection

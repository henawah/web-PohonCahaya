@extends('layouts.main')

@section('containers')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            @if (empty($cart))
                <div class="alert alert-info" role="alert">
                    Keranjang belanja kosong.
                </div>
            @else
                @foreach ($posts as $post)
                    <div class="post card mb-3 shadow">
                        <div class="row g-0">
                            <div class="col-md-2 me-2">
                                <input class="form-check-input" type="checkbox" value="{{ $post->id }}" id="checkbox{{ $post->id }}">
                                <label class="form-check-label" for="checkbox{{ $post->id }}"></label>
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded-start" alt="{{ $post->title }}">
                                @else
                                    <img src="https://source.unsplash.com/200x200?{{ $post->category->name }}" class="img-fluid rounded-start" alt="{{ $post->title }}">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text">Rp. {{ number_format($post->price) }}</p>
                                    <p class="card-text">Stock: <span id="stock{{ $post->id }}">{{ $post->stock }}</span></p>
                                    <p class="card-text">Berat: <span id="weight{{ $post->id }}">{{ $post->weight }} gram</span></p>
                                    <div class="quantity-controls">
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1 px-2 py-0" data-post-id="{{ $post->id }}">-</button>
                                        <span id="quantity{{ $post->id }}" class="m-2">{{ $cart[$post->id]['quantity'] }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-primary px-2 py-0" data-post-id="{{ $post->id }}">+</button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteCartItem('{{ $post->id }}')">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-lg-4">
            <div class="post card mb-6 shadow">
                <div class="card-body">
                    <p class="card-text">Rincian Belanja</p>
                    <ul id="checkoutList" class="list-group mb-3">
                        @foreach ($posts as $post)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $post->title }}
                                <span>{{ $cart[$post->id]['quantity'] }} x Rp. {{ number_format($post->price) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="card-text">Total Berat: <span id="totalWeight">0 gram</span></p>
                    <p class="card-text">Total Harga: Rp. <span id="totalPrice">0</span></p>
                    <a href="{{ route('orders.checkout') }}" id="checkoutButton" class="btn btn-first btn-lg d-flex justify-content-between align-items-center disabled">
                        <span class="btn btn-primary">Pembayaran</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", (event) => {
    // Tambahkan event listener untuk setiap checkbox
    document.querySelectorAll(".form-check-input").forEach((checkbox) => {
        checkbox.addEventListener("change", updateTotal);
    });

    // Tambahkan event listener untuk setiap tombol +/- (btn-outline-primary)
    document.querySelectorAll(".btn-outline-primary").forEach((button) => {
        button.addEventListener("click", function () {
            let postId = this.getAttribute("data-post-id");
            if (this.innerText === "-") {
                decreaseStock(postId);
            } else {
                increaseStock(postId);
            }
        });
    });

    updateTotal(); // Initial calculation
});

// Fungsi untuk mengurangi stok
function decreaseStock(postId) {
    let quantityElement = document.getElementById("quantity" + postId);
    let stockElement = document.getElementById("stock" + postId);
    let currentQuantity = parseInt(quantityElement.textContent);
    let stock = parseInt(stockElement.textContent);

    if (currentQuantity > 0) {
        currentQuantity--;
        stock++;
        quantityElement.textContent = currentQuantity;
        stockElement.textContent = stock;
    }
    updateTotal();
}

// Fungsi untuk menambah stok
function increaseStock(postId) {
    let quantityElement = document.getElementById("quantity" + postId);
    let stockElement = document.getElementById("stock" + postId);
    let currentQuantity = parseInt(quantityElement.textContent);
    let stock = parseInt(stockElement.textContent);

    if (stock > 0) {
        currentQuantity++;
        stock--;
        quantityElement.textContent = currentQuantity;
        stockElement.textContent = stock;
    }
    updateTotal();
}

function updateTotal() {
    let checkboxes = document.querySelectorAll(".form-check-input:checked");
    let total = 0;
    let totalWeight = 0;
    let checkoutList = document.getElementById("checkoutList");
    checkoutList.innerHTML = ""; // Bersihkan daftar sebelumnya

    checkboxes.forEach((checkbox) => {
        let postId = checkbox.value;
        let quantity = parseInt(document.getElementById("quantity" + postId).textContent);
        let price = parseInt(
            document
                .querySelector(`#checkbox${postId}`)
                .closest(".card")
                .querySelector(".card-text")
                .innerText.replace("Rp. ", "")
                .replace(",", "")
        );
        let title = document
            .querySelector(`#checkbox${postId}`)
            .closest(".card")
            .querySelector(".card-title").innerText;
        let weight = parseFloat(
            document.getElementById(`weight${postId}`).textContent.replace(" gram", "")
        );

        // Tambahkan item ke daftar checkout
        let li = document.createElement("li");
        li.className =
            "list-group-item d-flex justify-content-between align-items-center";
        li.innerHTML = `
            ${title}
            <span>${quantity} x Rp. ${price.toLocaleString("id-ID")}</span>
        `;
        checkoutList.appendChild(li);

        // Hitung total harga dan total berat
        total += quantity * price;
        totalWeight += weight * quantity;
    });

    // Tampilkan total harga dan total berat
    document.getElementById("totalPrice").textContent = total.toLocaleString("id-ID");
    document.getElementById("totalWeight").textContent = totalWeight.toFixed(2) + " gram";

    if (total > 0) {
        document.getElementById("checkoutButton").classList.remove("disabled");
    } else {
        document.getElementById("checkoutButton").classList.add("disabled");
    }
}

document.getElementById("cekOngkirForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const destination = document.getElementById("destination").value;
    const weight = document.getElementById("weight").value;
    const courier = document.getElementById("courier").value;

    fetch("{{ route('orders.checkongkir') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
        body: JSON.stringify({
            origin: "501",
            destination: destination,
            weight: weight,
            courier: courier,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            let result = `<ul>
                        <li>Asal Kota: ${data.rajaongkir.origin_details.city_name}</li>
                        <li>Kota Tujuan: ${data.rajaongkir.destination_details.city_name}</li>
                        <li>Berat Paket: ${data.rajaongkir.query.weight} gram</li>
                      </ul>`;

            data.rajaongkir.results.forEach((item) => {
                result += `<div>
                        <strong>${item.name}</strong>`;
                item.costs.forEach((cost) => {
                    result += `<div>
                            <span>${cost.service} - Rp. ${cost.cost[0].value.toLocaleString()} (Estimasi: ${cost.cost[0].etd} hari)</span>
                           </div>`;
                });
                result += `</div>`;
            });

            document.getElementById("ongkirResult").innerHTML = result;
        })
        .catch((error) => console.error("Error:", error));
});

document.getElementById("checkoutButton").addEventListener("click", function (event) {
    event.preventDefault();
    let selectedItems = [];
    document.querySelectorAll('input[type="checkbox"]:checked').forEach(function (checkbox) {
        selectedItems.push(checkbox.value);
    });
    document.getElementById("selectedItems").value = JSON.stringify(selectedItems);
    document.getElementById("checkoutForm").submit();
});
</script>

@endsection

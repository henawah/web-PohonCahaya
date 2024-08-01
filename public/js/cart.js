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
        let quantity = parseInt(
            document.getElementById("quantity" + postId).textContent
        );
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
            document
                .getElementById(`weight${postId}`)
                .textContent.replace(" gram", "")
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
    document.getElementById("totalPrice").textContent =
        total.toLocaleString("id-ID");
    document.getElementById("totalWeight").textContent =
        totalWeight.toFixed(2) + " gram";
}

document
    .getElementById("cekOngkirForm")
    .addEventListener("submit", function (event) {
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
                                <span>${
                                    cost.service
                                } - Rp. ${cost.cost[0].value.toLocaleString()} (Estimasi: ${
                            cost.cost[0].etd
                        } hari)</span>
                               </div>`;
                    });
                    result += `</div>`;
                });

                document.getElementById("ongkirResult").innerHTML = result;
            })
            .catch((error) => console.error("Error:", error));
    });
document
    .getElementById("checkoutButton")
    .addEventListener("click", function (event) {
        event.preventDefault();
        let selectedItems = [];
        document
            .querySelectorAll('input[type="checkbox"]:checked')
            .forEach(function (checkbox) {
                selectedItems.push(checkbox.value);
            });
        document.getElementById("selectedItems").value =
            JSON.stringify(selectedItems);
        document.getElementById("checkoutForm").submit();
    });

document.addEventListener("DOMContentLoaded", (event) => {
    document.querySelectorAll(".form-check-input").forEach((checkbox) => {
        checkbox.addEventListener("change", updateTotal);
    });

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
});

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
    let checkoutList = document.getElementById("checkoutList");
    checkoutList.innerHTML = ""; // Clear previous list

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

        // Append item to checkout list
        let li = document.createElement("li");
        li.className =
            "list-group-item d-flex justify-content-between align-items-center";
        li.innerHTML = `
            ${title}
            <span>${quantity} x Rp. ${price.toLocaleString("id-ID")}</span>
        `;
        checkoutList.appendChild(li);

        // Calculate total price
        total += quantity * price;
    });
    document.getElementById("totalPrice").textContent =
        total.toLocaleString("id-ID");
}

document.addEventListener("DOMContentLoaded", (event) => {
    document.querySelectorAll(".form-check-input").forEach((checkbox) => {
        checkbox.addEventListener("change", updateTotal);
    });

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

    document
        .getElementById("paymentButton")
        .addEventListener("click", function () {
            let selectedItems = [];
            let checkboxes = document.querySelectorAll(
                ".form-check-input:checked"
            );

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
                let image = document
                    .querySelector(`#checkbox${postId}`)
                    .closest(".card")
                    .querySelector("img").src;

                selectedItems.push({ postId, title, price, quantity, image });
            });

            fetch("/payment", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ items: selectedItems }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        window.location.href = "/payment";
                    }
                });
        });
});

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
    let checkoutList = document.getElementById("checkoutList");
    checkoutList.innerHTML = ""; // Clear previous list

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

        // Append item to checkout list
        let li = document.createElement("li");
        li.className =
            "list-group-item d-flex justify-content-between align-items-center";
        li.innerHTML = `
            ${title}
            <span>${quantity} x Rp. ${price.toLocaleString("id-ID")}</span>
        `;
        checkoutList.appendChild(li);

        // Calculate total price
        total += quantity * price;
    });
    document.getElementById("totalPrice").textContent =
        total.toLocaleString("id-ID");
}

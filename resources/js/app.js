require("./bootstrap");
window.addEventListener("scroll", function () {
    var image = document.querySelector(".scrolling-image");
    if (window.scrollY > 100) {
        // Atur nilai jarak scroll saat gambar dimasukkan ke dalam navbar
        image.style.opacity = 1; // Tampilkan gambar
    } else {
        image.style.opacity = 0; // Sembunyikan gambar
    }
});

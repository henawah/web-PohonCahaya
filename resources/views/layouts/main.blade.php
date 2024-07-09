<!doctype html>
<html lang="ar" >
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-8Y64rLkIlomP7tpR72Vs/lLXX3Am2NjeYk8CAodQl2RrTnMJ/7rrPxiPyvZgTQp9StI5fgyioNmKm9qJZQHTFQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link rel="stylesheet" href="style.css"> --}}
    <link href="{{ asset('style.css') }}" rel="stylesheet">

    <title>pohon cahaya | {{ $title }}</title>
    
  </head> 
  <body>
      @include('partials.navbar')
    <div class="container mt-4">
        @yield('containers')
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <footer>
      <div class="card w-200 mb-3 mt-4" style="background-color: #2d7d9f; " >
        <div class="container" >
          <div class="row " >
              <div class="col-md-4">
    <h5>Alamat</h5>
    <p>Jl. Serangan Umum 1 Maret, Jl. Bantul No.55-57, Daerah Istimewa Yogyakarta 55142</p>
    <!-- Tempelkan kode penanaman Google Maps di bawah -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.7544452202887!2d110.35358177412095!3d-7.815796777609325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5709921fc8b1%3A0xb683e4104812e88!2sPohon%20Cahaya!5e0!3m2!1sen!2sid!4v1715398559315!5m2!1sen!2sid" 
    width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
              </div>

              <div class="col-md-4">
                <h5>Kontak</h5>
                <p>
                    <a href="https://www.instagram.com/pohoncahayaofficial?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><img src="{{ asset('assets/ig.png') }}" alt="Instagram" width="50" height="50" fill="white" class="bi bi-search" ></a>
                    <a href="https://wa.me/6281391694388"><img src="{{ asset('assets/wa.png') }}" alt="WhatsApp" width="50" height="50" fill="white" class="bi bi-search" ></a>
                    <a href="https://x.com/ptpohoncahaya?t=tnE9FtO1eOsqkyGnk7SZEQ&s=09"><img src="{{ asset('assets/x.png') }}" alt="Twitter" width="50" height="50" fill="white" class="bi bi-search" ></a>
                    <a href="https://www.facebook.com/pohoncahayaofficial"><img src="{{ asset('assets/fb.png') }}" alt="Facebook" width="40" height="40" fill="white" class="bi bi-search" ></a>
                  </p>
            </div>
            
                
      <div class="col-md-4">
        <h5>Berliterasi Bersama Kami</h5>
        <p>Tingkatkan kemampuan menulis dan menjadi pencipta karya di dunia literasi Indonesia. Mari bersama kita majukan budaya literasi bangsa dan mencerdaskan kehidupan masyarakat.</p>
    </div>
          </div>
        </div>
      </div>
    </footer>
    <div class="container center-align">
      <p>  &copy; 2024 PT.Pohon Cahaya </p>
    </div>
  </body>
</html>
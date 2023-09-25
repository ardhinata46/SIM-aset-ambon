<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="{{URL::asset('assets/img/logo/logo.png')}}" rel="icon">
  <title>{{$title}}</title>
  <link rel="icon" href="{{ asset($profil->logo) }}" type="image/x-icon">
  <link href="{{URL::asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{URL::asset('assets/css/ruang-admin.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <style>
    .qr-code img {
      max-width: 50px;
      height: auto;
    }

    .img-profil {
      width: 100px;
      height: auto;
    }

    table {
      padding: 0;
    }

    th,
    td {
      font-size: 13px;
      text-align: left;
    }

    th {
      text-align: left;
    }

    .logo {
      border-radius: 50%;
    }

    a:hover {
      text-decoration: none;
    }


    .card-img,
    .nota-image,
    .ikon,
    .img-profil {
      transition: transform 0.3s;
    }

    .nota-image {
      width: 100px;
    }


    .nota-image:hover {
      transform: scale(1.1);
    }

    .img-profil {
      transform: scale(1.1);
    }

    .card-img {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      display: block;
      margin-left: auto;
      margin-right: auto;
      margin-top: auto;
      /* Tambahkan jarak atas */
    }

    .card-img:hover {
      transform: scale(1.1);
    }

    .sosmed {
      display: flex;
      justify-content: center;
    }

    .sosmed .fab {
      padding-left: 20px;
      padding-right: 20px;
    }

    .sosmed .ikon:hover {
      transform: scale(1.2);
    }

    .table-detail {
      max-width: 50%;
    }

    @media screen and (max-width: 767px) {
      .table-detail {
        max-width: 100%;
      }
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('superadmin.dashboard.index')}}">
        <div class="sidebar-brand-icon">
          <img class="logo" src="{{ asset($profil->logo) }}">
        </div>
        <div class="sidebar-brand-text mx-3">{{ $profil->nama_aplikasi }}</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link" href="{{route('superadmin.dashboard.index')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Data Master
      </div>

      <li class="nav-item">
        <a class="nav-link" href="{{route('superadmin.pengguna.index')}}">
          <i class="fas fa-fw fa-users"></i>
          <span>Pengguna</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true" aria-controls="collapseForm">
          <i class="fas fa-fw fa-cubes"></i>
          <span>Data Master</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('superadmin.tanah.index')}}">Tanah</a>
            <a class="collapse-item" href="{{route('superadmin.bangunan.index')}}">Bangunan</a>
            <a class="collapse-item" href="{{route('superadmin.kategori_barang.index')}}">Kategori Barang</a>
            <a class="collapse-item" href="{{route('superadmin.barang.index')}}">Barang</a>
            <a class="collapse-item" href="{{route('superadmin.ruangan.index')}}">Ruangan</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#inv" aria-expanded="true" aria-controls="inv">
          <i class="fas fa-fw fa-box"></i>
          <span>Data Inventaris</span>
        </a>
        <div id="inv" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('superadmin.inventaris_tanah.index')}}">Aset Tanah</a>
            <a class="collapse-item" href="{{route('superadmin.inventaris_bangunan.index')}}">Aset Bangunan</a>
            <a class="collapse-item" href="{{route('superadmin.inventaris_barang.index')}}">Aset Barang</a>
          </div>
        </div>
      </li>

      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Agenda
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Pengadaan" aria-expanded="true" aria-controls="Pengadaan">
          <i class="fas fa-fw fa-shopping-cart"></i>
          <span>Pengadaan Aset</span>
        </a>
        <div id="Pengadaan" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('superadmin.pengadaan_tanah.index')}}">Tanah</a>
            <a class=" collapse-item" href="{{route('superadmin.pengadaan_bangunan.index')}}">Bangunan</a>
            <a class="collapse-item" href="{{route('superadmin.pengadaan_barang.index')}}">Barang</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#alokasi" aria-expanded="true" aria-controls="alokasi">
          <i class="fas fa-exchange-alt"></i>
          <span>Alokasi Barang</span>
        </a>
        <div id="alokasi" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('superadmin.penempatan_barang.index')}}">Penempatan Barang</a>
            <a class="collapse-item" href="{{route('superadmin.mutasi_barang.index')}}">Mutasi Barang</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#peminjaman" aria-expanded="true" aria-controls="peminjaman">
          <i class="fas fa-fw fa-handshake"></i>
          <span>Transaksi Peminjaman</span>
        </a>
        <div id="peminjaman" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('superadmin.peminjaman_barang.index')}}">Peminjaman</a>
            <a class="collapse-item" href="{{route('superadmin.pengembalian_barang.index')}}">Pengembalian</a>
            <a class="collapse-item" href="{{route('superadmin.peminjaman_barang.belumKembali')}}">Barang Belum Kembali</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#perawatan" aria-expanded="true" aria-controls="perawatan">
          <i class="fas fa-fw fa-toolbox"></i>
          <span>Perawatan Aset </span>
        </a>
        <div id="perawatan" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('superadmin.perawatan_bangunan.index')}}">Bangunan</a>
            <a class="collapse-item" href="{{route('superadmin.perawatan_barang.index')}}">Barang</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Penghapusan" aria-expanded="true" aria-controls="Penghapusan">
          <i class="fas fa-fw fa-ban"></i>
          <span>Penghapusan Aset</span>
        </a>
        <div id="Penghapusan" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('superadmin.penghapusan_tanah.index')}}">Tanah</a>
            <a class="collapse-item" href="{{route('superadmin.penghapusan_bangunan.index')}}">Bangunan</a>
            <a class="collapse-item" href="{{route('superadmin.penghapusan_barang.index')}}">Barang</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#penyusutan" aria-expanded="true" aria-controls="penyusutan">
          <i class="fas fa-fw fa-chart-line fa-flip-vertical"></i>
          <span>Penyusutan Nilai Aset</span>
        </a>
        <div id="penyusutan" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('superadmin.penyusutan_bangunan.index')}}">Aset Bangunan</a>
            <a class="collapse-item" href="{{route('superadmin.penyusutan_barang.index')}}">Aset Barang</a>
          </div>
        </div>
      </li>

      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Lainnya
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Laporan" aria-expanded="true" aria-controls="Laporan">
          <i class="fas fa-fw fa-file"></i>
          <span>Laporan</span>
        </a>
        <div id="Laporan" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('superadmin.laporan.index')}}">Data Aset</a>
            <a class="collapse-item" href="{{ route ('superadmin.laporan.pengadaan') }}">Pengadaan Aset</a>
            <a class="collapse-item" href="{{ route ('superadmin.laporan.peminjaman') }}">Peminjaman Barang</a>
            <a class="collapse-item" href="{{ route ('superadmin.laporan.perawatan') }}">Perawatan Aset</a>
            <a class="collapse-item" href="{{ route ('superadmin.laporan.penghapusan') }}">Penghapusan Aset</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('superadmin.profil.index')}}">
          <i class="fas fa-fw fa-cogs"></i>
          <span>Pengaturan</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('superadmin.cetak_kode.index')}}">
          <i class="fas fa-fw fa-print"></i>
          <span>Cetak QR Code</span></a>
      </li>
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">


            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="{{ asset(Auth::user()->foto) }}" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">{{ auth()->user()->nama_pengguna }}
                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-toggle="modal" data-target="#logout">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          @yield ('sa.content')
        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; <script>
                document.write(new Date().getFullYear());
              </script> STTII Ambon | All Rights Reserved</span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <!-- <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a> -->

  <!-- Modal -->
  <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="logoutLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutLabel">Peringatan!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Konfirmasi Logout: Anda akan keluar dari sistem</p>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
            <a href="{{route('auth.logout')}}"><button type="button" class="btn btn-primary">Logout</button></a>
          </div>
        </div>
      </div>

      <script src="{{URL::asset('assets/vendor/jquery/jquery.min.js')}}"></script>
      <script src="{{URL::asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{URL::asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
      <script src="{{URL::asset('assets/js/ruang-admin.min.js')}}"></script>
      <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
      <script>
        $(document).ready(function() {
          let table = new DataTable('#myTable');
        });
      </script>

      <script>
        $(document).ready(function() {
          $('#addModal').on('hidden.bs.modal', function() {
            $('#error-container').hide();
          });

          $('#addForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
              type: $(this).attr('method'),
              url: $(this).attr('action'),
              data: $(this).serialize(),
              success: function(response) {
                alert(response.message);
                $('#addModal').modal('hide');
              },
              error: function(response) {
                var errors = response.responseJSON.errors;
                var errorMessage = 'Terjadi kesalahan:<br><ul>';

                $.each(errors, function(field, messages) {
                  $.each(messages, function(index, message) {
                    errorMessage += '<li>' + message + '</li>';
                  });
                });

                errorMessage += '</ul>';
                $('#error-container').html(errorMessage).show();
                $('#addModal').animate({
                  scrollTop: 0
                }, 'slow');
              }
            });
          });
        });
      </script>

      <script>
        function formatRupiah(input) {
          // Menghapus semua karakter non-digit dari input
          var angka = input.value.replace(/\D/g, '');

          // Menambahkan titik sebagai pemisah ribuan
          var formattedAngka = angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

          // Memasukkan nilai yang diformat ke dalam input
          input.value = formattedAngka;
        }
      </script>
      @yield('footer')
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-ARSIP</title>

    <!-- Fonts & Icons -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />


    <!-- Styles -->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(135deg, #007bff 0%, #00c6ff 100%);
            background-attachment: fixed;
            font-family: 'Nunito', sans-serif;
        }
        .dropdown-menu {
    z-index: 1050 !important; /* Pastikan dropdown tampil di atas */
}
.agenda-calendar {
    max-width: 90%;
    transform: scale(0.95); /* kecilkan ukuran total */
    transform-origin: top center;
    margin: auto;
}




        .sidebar {
            background: #332D87;
        }

        .sidebar .nav-link.active {
            background-color: #4e73df !important;
            color: #fff !important;
        }

        .navbar, .footer {
            background-color: #ffffffcc;
            backdrop-filter: blur(10px);
        }

        .navbar-custom {
            background: #fff;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e3e6f0;
            height: 64px;
        }

        .navbar .img-profile {
            object-fit: cover;
        }

        .brand-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            color: #343a40;
            text-shadow: 0 1px 1px rgba(0,0,0,0.1);
        }

        /* Custom Modal */
        .custom-modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(5px);
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        .custom-modal-content {
            background-color: #fff;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transform: translateY(-20px);
            animation: slideDown 0.3s ease forwards;
        }

        .custom-modal-header {
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .custom-modal-body {
            padding: 1.5rem;
            font-size: 16px;
        }

        .custom-modal-footer {
            padding: 1rem;
            text-align: right;
        }

        .close-btn {
            font-size: 1.5rem;
            cursor: pointer;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                background-color: rgba(0, 0, 0, 0);
            }
            to {
                background-color: rgba(0, 0, 0, 0.4);
            }
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column min-vh-100">
            <div id="content">
                @include('layouts.navbar')

                <div class="container-fluid py-4">
                    @yield('content')
                </div>
            </div>

            @include('layouts.footer')
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <!-- Custom Logout Modal -->
    <div id="customLogoutModal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="custom-modal-header bg-danger text-white">
                <h5 class="modal-title">Yakin ingin keluar?</h5>
                <span class="close-btn" id="closeLogoutModal">&times;</span>
            </div>
            <div class="custom-modal-body text-center">
                Pilih "Logout" jika kamu yakin ingin mengakhiri sesi.
            </div>
            <div class="custom-modal-footer">
                <button class="btn btn-secondary" id="cancelLogout">Batal</button>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>


    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

        // Logout modal script
        const logoutBtn = document.getElementById('logoutBtn');
        const logoutModal = document.getElementById('customLogoutModal');
        const closeLogoutModal = document.getElementById('closeLogoutModal');
        const cancelLogout = document.getElementById('cancelLogout');

        if (logoutBtn && logoutModal) {
            logoutBtn.addEventListener('click', function (e) {
                e.preventDefault();
                logoutModal.style.display = 'flex';
            });

            closeLogoutModal.addEventListener('click', () => {
                logoutModal.style.display = 'none';
            });

            cancelLogout.addEventListener('click', () => {
                logoutModal.style.display = 'none';
            });

            window.addEventListener('click', function (e) {
                if (e.target === logoutModal) {
                    logoutModal.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>

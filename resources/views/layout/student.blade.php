<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                z-index: 1040;
                left: -250px;
                top: 0;
                height: 100vh;
                transition: left 0.3s;
            }
            .sidebar.show {
                left: 0;
            }
            .main-content {
                margin-left: 0 !important;
            }
        }
        @media (min-width: 992px) {
            .main-content {
                margin-left: 250px;
            }
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.3);
            z-index: 1039;
        }
        .sidebar.show ~ .sidebar-overlay {
            display: block;
        }
        .nav-link.active, .nav-link:focus {
            background-color: #0e4a5a;
            font-weight: bold;
        }
        .nav-link .bi {
            margin-right: 8px;
            font-size: 1.2em;
            vertical-align: -0.125em;
        }
        .dashboard-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: flex-start;
        }
        .dashboard-card {
            flex: 1 1 220px;
            min-width: 220px;
            max-width: 320px;
        }
    </style>
</head>
<body>
    <div class="d-flex" style="min-height: 100vh;">
        <!-- Sidebar -->
        <nav class="sidebar d-flex flex-column align-items-center py-4 position-fixed" style="width: 250px; background: #155e75; height: 100vh;" aria-label="Sidebar Navigation">
            <!-- Logo -->
            <div class="mb-4">
                <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel Logo" width="80" height="80" class="rounded-circle bg-white p-2">
            </div>
            <!-- Navigation Links -->
            <ul class="nav flex-column w-100">
                <li class="nav-item text-uppercase text-white-50 small px-3 mb-2" style="letter-spacing: 1px;">
                    Main
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-white d-flex align-items-center {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-white d-flex align-items-center {{ request()->routeIs('student.clearance.request.form') ? 'active' : '' }}" href="{{ route('student.clearance.request.form') }}">
                        <i class="bi bi-journal-plus me-2"></i> Clearance Request
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-white d-flex align-items-center {{ request()->routeIs('student.clearance.status') ? 'active' : '' }}" href="{{ route('student.clearance.status') }}">
                        <i class="bi bi-clipboard-check me-2"></i> Clearance Status
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-white d-flex align-items-center {{ request()->routeIs('student.profile') ? 'active' : '' }}" href="{{ route('student.profile') }}">
                        <i class="bi bi-person-circle me-2"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white d-flex align-items-center" href="{{ url('/palm-pesa/pay') }}">
                        <i class="bi bi-credit-card me-2"></i> Palm Pesa Payment
                    </a>
                </li>
            </ul>
            <hr class="border-light w-75 my-3">
            <!-- Logout link at the bottom, centered with 20px padding from bottom -->
            <div class="mt-auto w-100 d-flex justify-content-center" style="padding-bottom: 20px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
        <!-- Overlay for mobile -->
        <div class="sidebar-overlay"></div>
        <!-- Main Content -->
        <div class="flex-grow-1 main-content" style="background: #f5f5f5; min-height: 100vh; margin-left: 250px;">
            <!-- Top Navbar only on right side -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="margin-left: 0;">
                <div class="container-fluid">
                    <button class="btn d-lg-none" id="sidebarToggle" aria-label="Toggle sidebar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <span class="navbar-brand ms-2">Student Dashboard</span>
                </div>
            </nav>
            <div class="container py-5">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle for mobile
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.querySelector('.sidebar-overlay');
        const navLinks = document.querySelectorAll('.sidebar .nav-link');

        sidebarToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            sidebar.classList.toggle('show');
            sidebarOverlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        });

        // Hide sidebar when clicking overlay
        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            sidebarOverlay.style.display = 'none';
        });

        // Hide sidebar when resizing to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('show');
                sidebarOverlay.style.display = 'none';
            }
        });

        // Hide sidebar after clicking a nav link (on mobile)
        navLinks.forEach(link => {
            link.addEventListener('click', function () {
                if (window.innerWidth < 992) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
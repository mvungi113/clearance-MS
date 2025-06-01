{{-- filepath: resources/views/layout/department.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
        }
        .sidebar {
            width: 250px;
            background: #0e4a5a !important;
            min-height: 100vh;
            transition: left 0.3s;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: #155e75;
            color: #fff !important;
        }
        .sidebar .nav-link {
            color: #e0e0e0;
        }
        .sidebar .nav-link i {
            font-size: 1.2rem;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.3);
            z-index: 1039;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                z-index: 1040;
                left: -250px;
                top: 0;
                height: 100vh;
            }
            .sidebar.show {
                left: 0;
            }
            .main-content {
                margin-left: 0 !important;
            }
            .sidebar.show ~ .sidebar-overlay {
                display: block;
            }
        }
        @media (min-width: 992px) {
            .main-content {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex" style="min-height: 100vh;">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column align-items-center py-4 position-fixed">
            <!-- Logo or Title -->
            <div class="mb-4">
                <span class="fs-4 text-white fw-bold"><i class="bi bi-building"></i> Department Panel</span>
            </div>
            <!-- Navigation Links -->
            <ul class="nav flex-column w-100">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('department.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('departments.index') }}">
                        <i class="bi bi-list-ul me-2"></i> Departments List
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="#">
                        <i class="bi bi-people me-2"></i> Staff
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="#">
                        <i class="bi bi-journal-check me-2"></i> Approvals
                    </a>
                </li>
            </ul>
            <!-- Logout link at the bottom, centered with 20px padding from bottom -->
            <div class="mt-auto w-100 d-flex justify-content-center" style="padding-bottom: 20px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-transparent border-0 text-white" style="font-size: 1rem; text-decoration: underline; cursor: pointer;">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        <!-- Overlay for mobile -->
        <div class="sidebar-overlay"></div>
        <!-- Main Content -->
        <div class="flex-grow-1 main-content" style="background: #f5f5f5; min-height: 100vh;">
            <!-- Top Navbar only on right side -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="margin-left: 0;">
                <div class="container-fluid">
                    <button class="btn d-lg-none" id="sidebarToggle">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <span class="navbar-brand ms-2"><i class="bi bi-building"></i> Department Dashboard</span>
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
    </script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .main {
            flex: 1;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            padding: 20px;
            color: white;
        }

        .sidebar .collapse a {
            padding-left: 20px;
            font-size: 0.95rem;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }

        .sidebar a:hover {
            color: white;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        footer {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
        }

        .header {
            background-color: #ffffff;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }

        .logout-button {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">@yield('title')</h5>
        <div class="d-flex align-items-center">
            <span class="me-3">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
            <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/dummy_user_image.jpg') }}"
                alt="Profile" width="28" height="28" class="rounded-circle me-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </div>
    </div>

    <div class="main">
        <div class="sidebar">
            {{-- <h5>Navigation</h5> --}}
            <a href="{{ route('dashboard') }}">Dashboard</a>
            @if (auth()->check() && auth()->user()->role === 'ADS')
                <a href="{{ route('president.index') }}">President</a>
            @endif
            @if (auth()->check() && auth()->user()->role === 'PRESIDENT')
                <a href="{{ route('member.index') }}">Members</a>
            @endif

            @if (auth()->user()->role === 'PRESIDENT')
                <a href="{{ route('notebooks.index') }}">Notebooks</a>
            @endif

            @if (auth()->user()->role === 'PRESIDENT')
                <a href="{{ route('loans.index') }}">Loans</a>
            @endif

            @if (auth()->user()->role === 'PRESIDENT')
                <a href="{{ route('thrift-loans.index') }}">Thrift Loans</a>
            @endif

            @if (in_array(auth()->user()->role, ['PRESIDENT', 'MEMBER']))
                <a href="{{ route('attendance.index') }}">Attendances</a>
            @endif

            @if (in_array(auth()->user()->role, ['MEMBER']))
                <a href="{{ route('fines.index') }}">Fines</a>
            @endif

            @if (in_array(auth()->user()->role, ['PRESIDENT', 'ADS']))
                <a href="{{ route('notifications.index') }}">Notifications</a>
            @endif

            @if (in_array(auth()->user()->role, ['PRESIDENT', 'ADS']))
                <a href="{{ route('coupons.index') }}">Coupons</a>
            @endif

            <a href="#settingsSubmenu" data-bs-toggle="collapse" aria-expanded="false"
                class="dropdown-toggle">Settings</a>
            <div class="collapse" id="settingsSubmenu">
                <a href="{{ route('profile.show') }}" class="ms-3">Update Profile</a>
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} Social Service Management
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha384-oP6b1D0Y8s1gJ7mO5y6JvK0z5t6z5v5z5z5z5z5z5z5z5z5z5z5z5z5z5z5z5z5" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('script')

</body>

</html>

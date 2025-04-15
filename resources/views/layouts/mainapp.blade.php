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
        <h5 class="mb-0">Admin Panel</h5>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>

    <div class="main">
        <div class="sidebar">
            <h5>Navigation</h5>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('president.index') }}">President</a>
            <a href="{{ route('member.index') }}">Members</a>
            <a href="{{ route('notebooks.index') }}">Notebooks</a>
            <a href="#">Settings</a>
            <!-- Add more links -->
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} Admin Panel. All rights reserved.
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha384-oP6b1D0Y8s1gJ7mO5y6JvK0z5t6z5v5z5z5z5z5z5z5z5z5z5z5z5z5z5z5z5z5" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @yield('script')

</body>

</html>

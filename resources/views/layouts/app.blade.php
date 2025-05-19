<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
        }
        .navbar {
            background-color: #007bff;
            padding: 10px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px;
        }
    </style>
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand text-white fw-bold" href="{{ route('customers.index') }}">
                    <i class="fas fa-users"></i> Customer Management
                </a>
                <div>
                    <a href="{{ route('customers.index') }}"><i class="fas fa-home"></i> Due Customers</a>
                    <a href="{{ route('customers.create') }}"><i class="fas fa-user-plus"></i> Add Customer</a>
                    <a href="{{ route('customers.no_due') }}" class=" btn-sm"><i class="fas fa-check"></i> No Due Customers</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="  m-4 content">
        @yield('content')
    </div>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Customer Management System. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

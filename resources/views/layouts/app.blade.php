<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Newsapp') }}</title>

    <!-- Add your CSS framework or custom CSS here, e.g., Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles') <!-- Push additional styles if needed -->
</head>
<body>
    <div class="container">
        @yield('content') <!-- This will be the content from other views like the password reset view -->
    </div>

    <!-- Add your JS framework or custom JS here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts') <!-- Push additional scripts if needed -->
</body>
</html>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIGAP')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            margin: 0;
            background: #f4f5f7;
            font-family: Arial, sans-serif;
        }

        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            min-width: 0;
            padding: 30px;
        }

        @media (max-width: 768px) {
            .app-layout {
                flex-direction: column;
            }

            .main-content {
                padding: 18px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <div class="app-layout">

        @include('layouts.sidebar')

        <main class="main-content">
            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISO 27001 Security Assessment Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .progress-bar {
            transition: width 0.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-white text-xl font-bold">ISO 27001 Security Assessment</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('security.index') }}" class="text-white hover:text-blue-200">Home</a>
                    <a href="{{ route('security.saved-companies') }}" class="text-white hover:text-blue-200">Saved Companies</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Profile page</title>
</head>
<body>
    <header class="bg-gray-100 shadow">
        <nav class="container mx-auto flex items-center justify-between px-6 py-4">
            <!-- Left: Website Title -->
            <div class="text-xl font-bold text-gray-800">
                Campus Connect
            </div>

            <!-- Right: Menu Links -->
            <div class="space-x-6">
                <a href="/login" class="text-gray-600 hover:text-gray-900 font-medium">Login</a>
                <a href="#" class="text-gray-600 hover:text-gray-900 font-medium">Profile</a>
            </div>
        </nav>
    </header>
    <main class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">My Profile</h2>

            <div class="mb-4">
                <label class="block mb-1 text-gray-600">Email Address</label>
                <p class="border px-3 py-2 rounded bg-gray-50">
                    UserTesting@gmail.com    
                </p>
            </div>

            <div class="text-center mt-4">
                <a href="/" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Back to Home
                </a>
            </div>
        </div>
    </main>

</body>
</html>
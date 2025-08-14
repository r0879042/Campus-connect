<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Article page</title>
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
                <a href="#" class="text-gray-600 hover:text-gray-900 font-medium">Login</a>
                <a href="#" class="text-gray-600 hover:text-gray-900 font-medium">Profile</a>
            </div>
        </nav>
    </header>
    <main class="container mx-auto px-6 py-10 max-w-5xl">
        <!-- Article Title -->
        <h1 class="text-4xl font-bold mb-4">Sample Article Title</h1>

        <!-- Date -->
        <p class="text-gray-500 text-sm mb-6">
            Published on August 13, 2025
        </p>

        <!-- Image -->
        <img src="{{ asset('images/articleImage1.png') }}"
            alt="Article image"
            class="w-full max-h-[500px] object-cover rounded-lg shadow mb-6">

        <!-- Content -->
        <div class="prose max-w-none mb-8">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada.</p>

            <p>Phasellus vel mauris nec orci placerat luctus. In nec justo
                id lacus luctus faucibus vel ut nulla. Integer ut nisl
                eu turpis egestas vestibulum.</p>
        </div>

        <!-- Navigation Links -->
        <div class="flex flex-row justify-between">

            <a href="/article-prev" class="text-blue-600 hover:underline">&larr; Previous Article</a>
            <a href="/article-next" class="text-blue-600 hover:underline">Next Article &rarr;</a>
        </div>
    </main>

</body>

</html>
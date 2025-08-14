<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Home page</title>
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
                <a href="#" class="text-gray-600 hover:text-gray-900 font-medium">News</a>
                <a href="/login" class="text-gray-600 hover:text-gray-900 font-medium">Login</a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-10 max-w-5xl">
        <h1 class="text-4xl font-bold mb-6 text-gray-900">News</h1>

        <!-- Search bar -->
        <form action="{{ route('articles.index') }}" method="GET" class="mb-6">
            <input
                type="search"
                name="q"
                placeholder="Search articles..."
                class="w-full px-4 py-3 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:border-transparent" />
        </form>

        <!-- Article list -->
        <ul class="space-y-4">
            @foreach ($articles as $article)
                <li class="p-4 bg-white rounded shadow hover:bg-gray-100 cursor-pointer transition">
                    <a href="{{ route('articles.show', $article->id) }}" class="no-underline text-gray-900">
                        <strong>{{ $article->title }}</strong>
                    </a>
                    <br>
                    <small>Published on {{ \Carbon\Carbon::parse($article->published_at)->format('F j, Y') }}</small>
                </li>
            @endforeach
        </ul>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    </main>
</body>
</html>

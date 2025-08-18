<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Create Article</title>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header (same as home page) -->
    <header class="bg-gray-100 shadow">
        <nav class="container mx-auto flex items-center justify-between px-6 py-4">
            <div class="text-xl font-bold text-gray-800">
                <a href="/articles" class="text-gray-600 hover:text-gray-900 font-medium">
                    Campus Connect
                </a>
            </div>
            <div class="space-x-6">
                <a href="/articles" class="text-gray-600 hover:text-gray-900 font-medium">News</a>
                <a href="/profile" class="text-gray-600 hover:text-gray-900 font-medium">My profile</a>
            </div>
        </nav>
    </header>

    <!-- Main content: centered form -->
    <main class="flex-grow flex items-center justify-center">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-lg">
            <h1 class="text-2xl font-bold mb-6 text-gray-900 text-center">Create New Article</h1>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="title">Title</label>
                    <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-600" value="{{ old('title') }}" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="content">Content</label>
                    <textarea name="content" id="content" rows="6" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-600" required>{{ old('content') }}</textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="image">Image (optional)</label>
                    <input type="file" name="image" id="image" class="block">
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-600 transition">Submit Article</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>

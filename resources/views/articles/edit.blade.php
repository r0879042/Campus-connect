<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Edit Article</title>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-gray-100 shadow">
        <nav class="container mx-auto flex items-center justify-between px-6 py-4">
            <div class="text-xl font-bold text-gray-800">
                <a href="/articles" class="text-gray-900 hover:text-gray-600 font-medium">
                    Campus Connect
                </a>
            </div>            
            <div class="space-x-6">
                <a href="/articles" class="text-gray-600 hover:text-gray-900 font-medium">News</a>
                <a href="/login" class="text-gray-600 hover:text-gray-900 font-medium">Login</a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center">
        <section class="bg-white p-8 rounded shadow-md w-full max-w-lg">
            
            <!-- Page Title -->
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">Edit Article</h2>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Update Article Form -->
            <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-gray-700 font-medium mb-1">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-600" 
                        value="{{ old('title', $article->title) }}" 
                        required
                    >
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-gray-700 font-medium mb-1">Content</label>
                    <textarea 
                        name="content" 
                        id="content" 
                        rows="6" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-600" 
                        required
                    >{{ old('content', $article->content) }}</textarea>
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-gray-700 font-medium mb-1">Image (optional)</label>
                    <input type="file" name="image" id="image" class="w-full">
                    
                    @if($article->image)
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Current Image:</p>
                            <img src="{{ asset('storage/' . $article->image) }}" alt="Article Image" class="h-16 mt-1 rounded border">
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-900 transition">
                        Update Article
                    </button>
                </div>
            </form>

            <!-- Publish Toggle -->
            <form id="publishForm-{{ $article->id }}" 
                action="{{ route('articles.toggle', $article->id) }}" 
                method="POST" 
                class="mt-6 flex items-center space-x-3">
                @csrf
                @method('PATCH')

                <input 
                    type="checkbox" 
                    name="published" 
                    id="published-{{ $article->id }}" 
                    value="1" 
                    {{ $article->published ? 'checked' : '' }} 
                    onchange="this.form.submit();"
                >
                <label for="published-{{ $article->id }}" class="text-gray-700 font-medium">Published</label>
            </form>

        </section>
    </main>

</body>
</html>

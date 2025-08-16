<?php
use Illuminate\Support\Facades\Auth;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>{{ $article->title }}</title>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-gray-100 shadow">
        <nav class="container mx-auto flex items-center justify-between px-6 py-4">
            <!-- Left: Website Title -->
            <div class="text-xl font-bold text-gray-800">
                Campus Connect
            </div>

            <!-- Right: Menu Links -->
            <?php if(Auth::check()): ?>
                <a href="/profile" class="text-gray-600 hover:text-gray-900 font-medium">My Profile</a>
            <?php else: ?>
                <a href="<?= route('login') ?>" class="text-gray-600 hover:text-gray-900 font-medium">Login</a>
            <?php endif; ?>
            
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-10 max-w-5xl flex-grow">
        
        <!-- Article Title -->
        <h1 class="text-4xl font-bold mb-4">{{ $article->title }}</h1>

        <!-- Date -->
        <p class="text-gray-500 text-sm mb-6">
            Published on {{ $article->created_at->format('F j, Y') }}
        </p>

        <!-- Image -->
        @if($article->image)
            <img src="{{ asset('storage/app/public/' . $article->image) }}"
                alt="{{ $article->title }}"
                class="w-full max-h-[500px] object-cover rounded-lg shadow mb-6">
        @endif

        <!-- Content -->
        <div class="prose max-w-none mb-8 break-words whitespace-pre-line">
            {!! e($article->content) !!}
        </div>


        <!-- Navigation Links -->
        <div class="flex justify-between text-blue-600 font-medium">
            @if($previousArticle)
                <a href="{{ route('articles.show', $previousArticle->id) }}" class="hover:underline">&larr; {{ $previousArticle->title }}</a>
            @else
                <span></span>
            @endif

            @if($nextArticle)
                <a href="{{ route('articles.show', $nextArticle->id) }}" class="hover:underline">{{ $nextArticle->title }} &rarr;</a>
            @endif
        </div>
    </main>

</body>
</html>

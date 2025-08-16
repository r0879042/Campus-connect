<?php
use Carbon\Carbon;

// Start session to access user info
session_start();

// Logged-in user
$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Articles Overview</title>
</head>
<body>
    <!-- Header -->
    <header class="bg-gray-100 shadow">
        <nav class="container mx-auto flex items-center justify-between px-6 py-4">
            <div class="text-xl font-bold text-gray-800">Campus Connect</div>
            <div class="space-x-6">
                <a href="/articles" class="text-gray-600 hover:text-gray-900 font-medium">News</a>
                <a href="/profile" class="text-gray-600 hover:text-gray-900 font-medium">Profile</a>
                <a href="/articles/create" class="text-gray-600 hover:text-gray-900 font-medium">Submit Article</a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-10 max-w-5xl">
        <h1 class="text-4xl font-bold mb-6 text-gray-900">Articles Overview</h1>

        <ul class="space-y-4">
            <?php foreach ($articles as $article): ?>
                <li class="flex justify-between items-center p-4 bg-white rounded shadow hover:bg-gray-100 transition">

                    <!-- Left: Article info -->
                    <div>
                        <a href="/articles/<?= $article->id ?>" class="text-gray-900 font-semibold text-lg">
                            <?= htmlspecialchars($article->title) ?>
                        </a>
                        <div class="flex items-center space-x-2 mt-1">
                            <?php if ($article->published): ?>
                                <span class="text-green-600 font-bold">✅ Published</span>
                            <?php else: ?>
                                <span class="text-red-600 font-bold">❌ Not Published</span>
                            <?php endif; ?>
                            <small class="text-gray-500">
                                Published on <?= $article->published_at ? date('F j, Y', strtotime($article->published_at)) : 'N/A' ?>
                            </small>
                        </div>
                    </div>

                    <!-- Right: Edit/Delete -->
                    <div class="flex flex-col swhpace-y-1">
                        <a href="/articles/<?= $article->id ?>/edit/" class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 text-center">Edit</a>
                        <form action="/articles/delete/<?= $article->id ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                            <input type="hidden" name="_token" value="<?= htmlspecialchars($_SESSION['_token'] ?? '') ?>">
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Delete</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>
</html>

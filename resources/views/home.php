<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Home page</title>
</head>
<body class="bg-sky-50">
    <header class="bg-gray-100 shadow">
        <nav class="container mx-auto flex items-center justify-between px-6 py-4">
            <!-- Left: Website Title -->
            <div class="text-xl font-bold text-gray-800">
                <a href="/articles" class="text-gray-900 hover:text-gray-600 font-medium">
                    Campus Connect
                </a>
            </div>
            <!-- Right: Menu Links -->
            <div class="space-x-6">
                <a href="/articles" class="text-gray-600 hover:text-gray-900 font-medium">News</a>

                <?php if(Auth::check()): ?>
                    <a href="/profile" class="text-gray-600 hover:text-gray-900 font-medium">My Profile</a>
                    <a href="/overview" class="text-gray-600 hover:text-gray-900 font-medium">Articles Overview</a>
                <?php else: ?>
                    <a href="<?= route('login') ?>" class="text-gray-600 hover:text-gray-900 font-medium">Login</a>
                <?php endif; ?>

            </div>
        </nav>
    </header>


    <main class="container mx-auto px-6 py-10 max-w-5xl bg-white">
        <h1 class="text-4xl font-bold mb-6 text-gray-900">News</h1>

        <!-- Search bar -->
        <form action="/articles" method="GET" class="mb-6">
            <input
                type="search"
                name="q"
                placeholder="Search articles..."
                value="<?= htmlspecialchars(request()->get('q')) ?>"
                class="w-full px-4 py-3 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:border-transparent" />
        </form>

        <!-- Article list -->
        <ul class="space-y-4">
            <?php foreach ($articles as $article): ?>
                <?php if ($article->published): // Only show published articles ?>
                    <li class="p-4 bg-white rounded shadow hover:bg-gray-100 cursor-pointer transition">
                        <a href="/articles/<?= $article->id ?>" class="no-underline text-gray-900">
                            <strong><?= htmlspecialchars($article->title) ?></strong>
                        </a>
                        <br>
                        <small>Published on <?= Carbon::parse($article->published_at)->format('F j, Y') ?></small>
                        <br>
                        <div class="mt-2">
                            <img src="<?= asset('storage/' . $article->image) ?>" 
                                alt="Article Image" 
                                class="h-50 mt-1 rounded border">
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>


        <!-- Pagination (example placeholder, adjust with your PHP pagination) -->
        <div class="mt-8">
            <?php if (isset($paginationLinks)) echo $paginationLinks; ?>
        </div>
    </main>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this article?');
        }
    </script>

</body>
</html>

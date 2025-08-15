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
<body>
    <header class="bg-gray-100 shadow">
        <nav class="container mx-auto flex items-center justify-between px-6 py-4">
            <!-- Left: Website Title -->
            <div class="text-xl font-bold text-gray-800">Campus Connect</div>

            <!-- Right: Menu Links -->
            <div class="space-x-6">
                <a href="#" class="text-gray-600 hover:text-gray-900 font-medium">News</a>

                <?php if(Auth::check()): ?>
                    <a href="/profile" class="text-gray-600 hover:text-gray-900 font-medium">My Profile</a>

                    <?php if(Auth::user()->role === 'admin'): ?>
                        <a href="/articles/overview" class="text-gray-600 hover:text-gray-900 font-medium">Articles Overview</a>
                        <a href="/articles/create" class="text-gray-600 hover:text-gray-900 font-medium">Create an Article</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?= route('login') ?>" class="text-gray-600 hover:text-gray-900 font-medium">Login</a>
                <?php endif; ?>

            </div>
        </nav>
    </header>


    <main class="container mx-auto px-6 py-10 max-w-5xl">
        <h1 class="text-4xl font-bold mb-6 text-gray-900">News</h1>

        <!-- Search bar -->
        <form action="/articles" method="GET" class="mb-6">
            <input
                type="search"
                name="q"
                placeholder="Search articles..."
                class="w-full px-4 py-3 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:border-transparent" />
        </form>

        <!-- Article list -->
        <ul class="space-y-4">
            <?php foreach ($articles as $article): ?>
                <li class="p-4 bg-white rounded shadow hover:bg-gray-100 cursor-pointer transition">
                    <a href="/articles/<?= $article->id ?>" class="no-underline text-gray-900">
                        <strong><?= htmlspecialchars($article->title) ?></strong>
                    </a>
                    <br>
                    <small>Published on <?= Carbon::parse($article->published_at)->format('F j, Y') ?></small>

                    <div class="space-x-2 mt-2">
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                            <!-- Edit link -->
                            <a href="/articles/edit.php?id=<?= $article->id ?>" class="text-blue-600 hover:underline">Edit</a>

                            <!-- Delete form -->
                            <form action="/articles/delete.php" method="POST" class="inline" onsubmit="return confirmDelete();">
                                <input type="hidden" name="id" value="<?= $article->id ?>">
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </li>
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

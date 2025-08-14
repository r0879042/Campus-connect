<!-- Start of mock up example -->

<?php
//TODO: Replace with real DB queries
$articles = [
    ['title' => 'Article 1', 'published_at' => '2025-08-10'],
    ['title' => 'Article 2', 'published_at' => '2025-08-09'],
    ['title' => 'Article 3', 'published_at' => '2025-08-08'],
    ['title' => 'Article 4', 'published_at' => '2025-08-07'],
    ['title' => 'Article 5', 'published_at' => '2025-08-06'],
    ['title' => 'Article 6', 'published_at' => '2025-08-07'],
    ['title' => 'Article 7', 'published_at' => '2025-08-08'],
    ['title' => 'Article 8', 'published_at' => '2025-08-09'],
    ['title' => 'Article 9', 'published_at' => '2025-08-10'],
    ['title' => 'Article 10', 'published_at' => '2025-08-11S'],
];

// Pagination logic: 5 articles per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 5;
$totalArticles = count($articles);
$totalPages = ceil($totalArticles / $perPage);

$start = ($page - 1) * $perPage;
$articlesForPage = array_slice($articles, $start, $perPage);
?>
<!-- End of mock up example -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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
        <form action="#" method="GET" class="mb-6">
            <input
                type="search"
                name="q"
                placeholder="Search articles..."
                class="w-full px-4 py-3 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:border-transparent" />
        </form>
        <ul class="space-y-4">
            <?php foreach ($articlesForPage as $article): ?>
                <li class="p-4 bg-white rounded shadow hover:bg-gray-100 cursor-pointer transition">
                    <a href="/articles" style="text-decoration: none; color: inherit;">
                        <strong><?= htmlspecialchars($article['title']) ?></strong>
                    </a>
                    <br>
                    <small>Published on <?= date('F j, Y', strtotime($article['published_at'])) ?></small>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="mt-8">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
            <?php endif; ?>

            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <a href="?page=<?= $p ?>" class="<?= $p === $page ? 'active' : '' ?>"><?= $p ?></a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>
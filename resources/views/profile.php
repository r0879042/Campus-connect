<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>My Profile</title>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <header class="bg-gray-100 shadow">
        <nav class="container mx-auto flex items-center justify-between px-6 py-4">
            <div class="text-xl font-bold text-gray-800">Campus Connect</div>
            <div class="space-x-6 flex items-center">
                <a href="<?= route('articles.index') ?>" class="text-gray-600 hover:text-gray-900 font-medium">News</a>

                <form method="POST" action="<?= route('logout') ?>" class="inline">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                        Disconnect
                    </button>
                </form>
            </div>
        </nav>
    </header>

    <main class="flex-grow flex items-center justify-center">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">My Profile</h2>
            <div class="mb-4">
                <label>Email Address</label>
                <p class="border px-3 py-2 rounded bg-gray-50"><?= htmlspecialchars($user->email) ?></p>
            </div>
            <div class="text-center mt-4">
                <a href="/" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Back to Home</a>
            </div>
        </div>
    </main>
</body>
</html>

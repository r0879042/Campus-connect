<?php
use Illuminate\Support\Facades\Auth;

// Success message
$success = session('success');
$currentUser = Auth::user();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-gray-100 shadow">
        <nav class="container mx-auto flex items-center justify-between px-6 py-4">
            <div class="text-xl font-bold text-gray-800">
                <a href="/articles" class="text-gray-600 hover:text-gray-900 font-medium">
                    Campus Connect
                </a>
            </div>            <div class="space-x-6 flex items-center">
                <a href="<?= route('articles.index') ?>" class="text-gray-600 hover:text-gray-900 font-medium">News</a>
                <a href="/admins" class="text-gray-600 hover:text-gray-900 font-medium">Admin</a>

                <form method="POST" action="<?= route('logout') ?>" class="inline">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                        Disconnect
                    </button>
                </form>
            </div>
        </nav>
    </header>
    <div class="max-w-4xl mx-auto bg-white shadow rounded p-6">
        <h1 class="text-2xl font-bold mb-4">All Users</h1>

        <?php if ($success): ?>
            <p class="text-green-600 mb-4"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $user->id ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($user->email) ?></td>
                        <td class="border px-4 py-2">
                        <?php if ($user->id !== $currentUser->id && $user->role !== 'admin'): ?>
                                <form action="<?= route('users.destroy', $user->id) ?>" method="POST" onsubmit="return confirm('Are you sure?');" class="inline justify-item:centers">
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" >Delete</button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-400"> - </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

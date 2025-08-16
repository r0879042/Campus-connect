<?php

use Illuminate\Support\Facades\Auth;

$currentUser = Auth::user();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Administrators</title>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Administrators</h1>

        <table class="w-full bg-white shadow rounded overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Role</th>
                    <th class="py-3 px-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4"><?= htmlspecialchars($admin->email) ?></td>
                        <td class="py-3 px-4 capitalize"><?= htmlspecialchars($admin->role) ?></td>
                        <td class="py-3 px-4 text-center">
                            <?php if ($currentUser->id !== $admin->id): ?>
                                <form action="/admins/delete.php" method="POST" onsubmit="return confirm('Are you sure you want to remove this admin?');" class="inline-block">
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="id" value="<?= $admin->id ?>">

                                    <button 
                                        type="submit" 
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        Delete
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-500 italic">You</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Show error message if exists
$error = session('error');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Register</title>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

        <?php if($error): ?>
            <p class="text-red-600 mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="<?= route('register') ?>">
            <input type="hidden" name="_token" value="<?= csrf_token() ?>">

            <div class="mb-4">
                <label>Email</label>
                <input type="email" name="email" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label>Password</label>
                <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Register</button>
        </form>

        <p class="mt-4 text-center text-sm">
            Already have an account? <a href="<?= route('login') ?>" class="text-blue-600 hover:underline">Login</a>
        </p>
    </div>

</body>
</html>
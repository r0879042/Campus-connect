<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Overview</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <h1 class="text-3xl font-bold mb-6">Article Overview</h1>

    <a href="{{ route('articles.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add New Article</a>

    <table class="w-full bg-white rounded shadow overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left">Title</th>
                <th class="px-4 py-2">Published</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2">{{ $article->title }}</td>
                <td class="px-4 py-2 text-center">
                    {{ $article->published ? 'Yes' : 'No' }}
                </td>
                <td class="px-4 py-2 space-x-2 text-center">
                    <a href="{{ route('articles.edit', $article->id) }}" class="bg-yellow-400 px-3 py-1 rounded hover:bg-yellow-500 text-white">Edit</a>

                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 px-3 py-1 rounded hover:bg-red-600 text-white" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

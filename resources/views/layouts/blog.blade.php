<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Matflo Blog')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.9.6/tailwind.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@tailwindcss/typography@0.2.x/dist/typography.min.css" />
</head>
<body>

<header class="text-gray-700 body-font border-b">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <nav class="flex flex-wrap items-center text-base m-auto">
            <a href="/" class="mr-5 hover:text-gray-900">Home</a>
            <a href="/blogs" class="mr-5 hover:text-gray-900">Blog</a>
            <a href="/about" class="mr-5 hover:text-gray-900">About</a>
        </nav>
    </div>
</header>

    @yield('content')


</body>
</html>
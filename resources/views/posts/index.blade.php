@extends('layouts.blog')

@section('content')

    <div class="container mx-auto p-5">
        <h1 class="text-4xl mt-12 text-center tracking-tight leading-10 font-extrabold text-gray-900 sm:text-5xl sm:leading-none md:text-6xl">
            Welcome to The Matflo Blog
        </h1>

        <div class="mt-10 max-w-xl mx-auto">
            @foreach($posts as $post)
                <div class="border-b mb-5 pb-5 border-gray-200">
                    <a href="/post/{{ $post->slug }}" class="text-2xl font-bold mb-2">{{ $post->title }}</a>
                    <p>{{ Str::limit(strip_tags($post->body), 100) }}</p>
                </div>
            @endforeach
        </div>
    </div>

@endsection
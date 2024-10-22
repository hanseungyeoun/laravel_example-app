<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <div class="container p-5">
    <h1 class="text-2xl">글쓰기</h1>
    <form action="/articles" method="post" class="mt-5">
      @csrf
      <input type="text" name='body' class="block w-full mb-5" value="{{old('body')}}">
      @error('body')
      <p class="text-xs text-red-500 my-3">{{$message}}</p>
      @enderror
      <button class="py-1 px-3 bg-black text-white rounded text-xs">저장하기</button>
    </form>
   </div>
</body>
</html>
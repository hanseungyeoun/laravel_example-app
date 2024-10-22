<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- Styles / Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <div class="container p-5">
    <h1 class="text-2xl mb-5" >글 목록 </h1>
    @foreach ($articles as $article)
      <div class="background-white border rounded mb-3 p-3">
        <p>{{$article->body}}</p>
        {{-- <p>{{$article->created_at->format('Y년 m월 d일 H:i:s')}}</p> --}}
        <p>{{$article->created_at->diffForHumans()}}</p>
        <p>{{$article->user->name}}</p>
      </div>
    @endforeach
    <div class="container p-5">
      {{$articles->links()}}
    </div>
  </div>
</body>

</html>
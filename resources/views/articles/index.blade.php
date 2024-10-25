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
        <p>{{$article->user->name}}</p>
        <p><a href="{{route('articles.create', ['article'=>$article->id])}}">{{$article->created_at->diffForHumans()}}</a></p>
        <div class="flex flex-row mt-2">
          <p class="mr-1">
            <a  
              class="boutton rounded bg-blue-500 px-2 py-1 text-xs color-white"
              href="{{route('articles.edit', ['article'=>$article->id])}}">
              수정
            </a>
          </p>
          <form action="{{route('articles.delete',  ['article'=>$article->id])}}" method="POST">
            @csrf
            @method("delete")
            <button class="py-1 px-3 bg-red-500 text-white rounded text-xs">삭제</button>
          </form>
        </div>

      </div>
    @endforeach
    <div class="container p-5">
      {{$articles->links()}}
    </div>
  </div>
</body>

</html>
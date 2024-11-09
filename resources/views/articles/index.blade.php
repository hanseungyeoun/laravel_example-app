<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('글 목록') }}
    </h2>
  </x-slot>
  <div class="container p-5">
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
          <form action="{{route('articles.destroy',  ['article'=>$article->id])}}" method="POST">
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
</x-app-layout>
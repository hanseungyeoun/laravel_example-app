<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('글수정') }}
    </h2>
  </x-slot>
  <div class="container p-5">
    <h1 class="text-2xl">글수정</h1>
    <form action="{{route('articles.update', ['article'=>$article->id])}}" method="post" class="mt-5">
      @csrf
      {{-- <input type="hidden" name="_method" value="PUT"> --}}
      @method('PATCH')
      <input type="text" name='body' class="block w-full mb-5" value="{{old('body') ?? $article->body}}">
      @error('body')
      <p class="text-xs text-red-500 my-3">{{$message}}</p>
      @enderror
      <button class="py-1 px-3 bg-black text-white rounded text-xs">저장하기</button>
    </form>
  </div>
</x-app-layout>
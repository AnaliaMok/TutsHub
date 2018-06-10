@extends('layouts.default')

@section('header')

@if($page->slug === 'home')
{{-- TODO: Add gradient --}}
<header class="header header--home">
@else
<header class="header" style="background-color: {{ $page->header_background_color }};">
@endif
  <div class="header__content">
    <h2>{{ $page->header_title }}</h2>
    <p>{{ $page->header_content }}</p>
  </div>
</header>
@endsection

@section('content')
@if(count($posts) > 0)
<div class="page">
  <ul class="page__post-content">
    @foreach ($posts as $post)
    <li class="page__post-content__post">
      <div class="page__post-content__post__image-wrapper">
        <img src="storage/{{ $post->image }}" alt="{{ $post->title ?? $post->name }}">
      </div>
      <div class="page__post-content__post__content">
        @if( isset($post->categories)) {{-- && count($post->categories > 0) ) --}}
          @foreach( $post->categories as $category )
            <span class="category">{{ $category->name }}</span>
          @endforeach
        @endif
      </div>
      {{ $post->title ?? $post->name }}
    </li>
    @endforeach
  </ul>
</div>
@else
  <strong>Sorry, there are no available posts</strong>
@endif
@endsection
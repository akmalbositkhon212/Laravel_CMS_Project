@extends('layouts.app')
@section('content')
<a href="{{route('posts.create')}}">Create Post</a>
  <ol>
      @foreach($posts as $post)
        <!-- <li><a href="posts/{{$post->id}}">{{$post->title}}</a></li> -->
              <li><a href="{{route('posts.show', $post->id)}}">{{$post->title}}</a></li>
      @endforeach
  </ol>


@stop

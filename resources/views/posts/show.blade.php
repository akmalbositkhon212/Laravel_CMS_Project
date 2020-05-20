@extends('layouts.app')
@section('content')
<h1>{{$post->title}}</h1>
<p>{{$post->content}}</p>
<a href="{{route('posts.edit', $post->id)}}">edit</a>
<a href="{{route('posts.index')}}">home</a>
<form class="" action="/posts/{{$post->id}}" method="post">
  <input type="hidden" name="_method" value="DELETE">
  {{csrf_field()}}
        <input type="submit" name="submit" value="DELETE">
    </form>
@stop

@extends('layouts.app')
@section('content')
<h3>Edit Post</h3>
  <form class="" action="/posts/{{$post->id}}" method="post">
    <input type="hidden" name="_method" value="PUT">
    <input type="text" name="title" placeholder="Enter title" value="{{$post->title}}">
    <input type="textarea" name="content" placeholder="Enter content" value="{{$post->content}}">
    {{csrf_field()}}
    <input type="submit" name="submit" value="UPDATE">
    <a href="{{route('posts.index')}}">home</a>
  </form>
  <form class="" action="/posts/{{$post->id}}" method="post">
    <input type="hidden" name="_method" value="DELETE">
      {{csrf_field()}}
          <input type="submit" name="submit" value="DELETE">
      </form>
@stop

@extends('layouts.app')
@section('content')
<h3>Create Post</h3>
  <form class="" action="/posts" method="post">
    <input type="text" name="title" placeholder="Enter title" value="">
    <input type="textarea" name="content" placeholder="Enter content" value="">
    {{csrf_field()}}
    <input type="submit" name="submit" value="submit">
  </form>
<a href="{{route('posts.index')}}">home</a>
@stop

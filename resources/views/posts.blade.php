@extends('layouts.app')
@section('content')
Posts {{$id}}  {{$name}}
@if(count($posts))
<ul>
@foreach($posts as $post)

<li>{{$post}}</li>
@endforeach()
</ul>
@endif()

@stop

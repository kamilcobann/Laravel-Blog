@extends('front.layouts.master')
@section('title',$article->title)
@section('content')
@section('bg',$article->image)
<div class="col-md-9">
   {!!$article->content!!}
   <span>
    Times Read: <b>{{$article->hit}}</b>
   </span>
</div>


@include('front.widgets.categoryWidget');
@endsection
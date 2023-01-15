@extends('front.layouts.master')
@section('title',$page->title)
@section('content')
@section('bg',$page->image)
<div class="col-md-9">
   
    <div class="row justify-content-center">
       {!! $page->content !!}
    </div>
   <br>
</div>

@endsection






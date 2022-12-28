@extends('front.layouts.master')
@section('title',$category->name)
@section('content')

<div class="col-md-9">
    @if(count($articles )> 0)
    @foreach ($articles as $article)
    <!-- Post preview-->
    <div class="post-preview">
        <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}">
            <h2 class="post-title">{!!$article->title!!}</h2>
            
        <img src="{{$article->image}}" alt="">
            <h3 class="post-subtitle">{!!str_limit($article->content,75,)!!}</h3>
        </a>
        <p class="post-meta">Kategori :
            <a href="#!">{{$article->getCategory->name}}</a>
            <span class="float-end">{{$article->created_at->diffForHumans()}}</span>
        </p>
        
    </div>
    <!-- Divider-->
    @if(!($loop->last))
    <hr class="my-4" />
    @endif
    @endforeach
    
    @else
    <div class="alert alert-danger ">
        <h1>No articles on this category</h1>
    </div>
    @endif
    <!-- Pager-->
    {{-- <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="#!">Older Posts →</a></div> --}}
</div>

@include('front.widgets.categoryWidget');
@endsection
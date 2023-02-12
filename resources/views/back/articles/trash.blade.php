@extends('back.layouts.master')
@section('title','Tüm Makaleler')
@section('content')

<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><strong>{{$articles->count()}} makale bulundu</strong>
                        
                            <span class="mx-1">
                                <a href="{{route('admin.articles.index')}}" class="btn btn-success btn-sm"><i class="fa fa-file mx-1"></i>Aktif Makaleler</a>
                            </span>
                        </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Başlık</th>
                                            <th>Kategori</th>
                                            <th>Hit</th>
                                            <th>Oluş. Tarihi</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($articles as $article)
                                        <tr>
                                            <td>
                                                <img src="/{{$article->image}}" alt="" width="200">
                                            </td>
                                            <td>{{$article->title}}</td>
                                            <td>{{$article->getCategory->name}}</td>
                                            <td>{{$article->hit}}</td>
                                            <td>{{$article->created_at->diffForHumans()}}</td>
                                            <td>

                                            <a href="{{route('admin.recycle',$article->id)}}" title="Silmekten Kurtar" class="btn btn-sm btn-primary">
                                                <i class="fa-recycle fa"></i>
                                                </a>

                                                <a href="{{route('admin.hard-delete',$article->id)}}" title="Sil" class="btn btn-sm btn-danger">
                                                <i class="fa-times fa"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

@endsection

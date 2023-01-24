@extends('back.layouts.master')
@section('title','Tüm Makaleler')
@section('content')

<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><strong>{{$articles->count()}} makale bulundu</strong></h6>
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
                                            <th>Durum</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($articles as $article)
                                        <tr>
                                            <td>
                                                <img src="{{$article->image}}" alt="" width="200">
                                            </td>
                                            <td>{{$article->title}}</td>
                                            <td>{{$article->getCategory->name}}</td>
                                            <td>{{$article->hit}}</td>
                                            <td>{{$article->created_at->diffForHumans()}}</td>
                                            <td> <span class ={!!$article->status==0 ? "'text-danger'>Pasif" : "'text-success'>Aktif" !!}</span></td>
                                            <td>
                                                <a href="#" title="Görüntüle" class="btn btn-sm btn-success">
                                                    <i class="fa-eye fa"></i>
                                                </a>
                                                <a href="#" title="Düzenle" class="btn btn-sm btn-primary">
                                                <i class="fa-pen fa"></i>
                                                </a>
                                                <a href="#" title="Sil" class="btn btn-sm btn-danger">
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
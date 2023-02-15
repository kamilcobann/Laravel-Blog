@extends('back.layouts.master')
@section('title','Tüm Sayfalar')
@section('content')

<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><strong>{{$pages->count()}} sayfa bulundu</strong>
                        </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Başlık</th>
                                            <th>Durum</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pages as $page)
                                        <tr>
                                            <td>
                                                <img src="/{{$page->image}}" alt="" width="200">
                                            </td>
                                            <td>{{$page->title}}</td>
                                            <td> 
                                            <input class="switch" page-id="{{$page->id}}"  type="checkbox" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" @if($page->status==1) checked @endif data-toggle="toggle">

                                            </td>
                                            <td>
                                                <a href="{{route('page',$page->slug)}}" class="btn btn-sm btn-success" title="Görüntüle"><i class="fa-eye fa"></i></a>
                                                
                                                <a href="{{route('admin.page.edit',$page->id)}}" class="btn btn-sm btn-primary" title="Düzenle"><i class="fa-pen fa"></i></a>
                                                
                                                <a href="{{route('admin.page.delete',$page->id)}}" class="btn btn-sm btn-danger" title="Sil"><i class="fa-times fa"></i>
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

@endsection
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(function () {
        $('.switch').change(function () {
            id = $(this)[0].getAttribute('page-id');
            statu = $(this).prop('checked');
            $.get("{{route('admin.page.switch')}}",{id:id,statu,statu},function (data,status) {
                console.log(data);
            })
        })
    })
</script>
@endsection
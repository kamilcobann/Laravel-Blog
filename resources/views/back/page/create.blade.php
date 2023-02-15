@extends('back.layouts.master')
@section('title','Sayfa Oluştur')
@section('content')

<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"></h6>
                        </div>
                        <div class="card-body">
                           <form method="post" action="{{route('admin.page.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if ($errors->count() > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors as $err)
                                        {{$err}}
                                    @endforeach
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Sayfa Başlığı</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Fotoğraf</label>
                                <input type="file" name="image" id="image" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>İçerik</label>
                                <textarea rows="4" name="content" id="editor" class="form-control" required></textarea>
                            </div>

                            
                                <button type="submit" class="btn btn-primary btn-block">Sayfa Oluştur</button>
                            
                           </form>
                        </div>
</div>

@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

@endsection
@section('js')
<!-- include summernote css/js -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function(){
        $('#editor').summernote(
            {'height':300}
        )
    })
</script>
@endsection
@extends('back.layouts.master')
@section('title','Tüm Kategoriler')
@section('content')

<div class="row">
    <div class="col-md-4">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('admin.category.create')}}">
                    @csrf
                    <div class="form-group">
                        <label>Kategori Adı</label>
                        <input type="text" class="form-control" name="category" required />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tüm Kategoriler</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kategori adı</th>
                                <th>Makale sayısı</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{$category->name}}</td>
                                <td>{{$category->articleCount()}}</td>
                                <td>
                                    <input class="switch" category-id="{{$category->id}}" type="checkbox" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" @if($category->status==1) checked @endif data-toggle="toggle">
                                </td>
                                <td>
                                    <a category-id="{{$category->id}}" class="edit-click btn btn-sm btn-primary" title="Kategoriyi Düzenle" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
                                    <a category-id="{{$category->id}}" category-count="{{$category->articleCount()}}" class="remove-click btn btn-sm btn-danger" title="Kategoriyi Sil" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Kategori Düzenle</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="{{route('admin.category.update')}}" id="updateForm">
                    @csrf
                    <div class="form-group">
                        <label>Kategori Adı</label>
                        <input type="text" id="category" name="newcategory" class="form-control">
                        <input type="hidden" name="id" id="category_id">
                    </div>

                    <div class="form-group">
                        <label>Kategori Slug</label>
                        <input type="text" id="slug" name="newslug" class="form-control">
                    </div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-success">Kaydet</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Kategori Sil</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="{{route('admin.category.delete')}}" method="post">
                @csrf
                <input type="hidden" name="id" id="delete-id">
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="articleAlert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <button type="submit" id="deleteButton" class="btn btn-success">Sil</button>

                </div>
            </form>
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
    $(function() {
        $('.remove-click').click(function() {
            id = $(this)[0].getAttribute('category-id');
            count = $(this)[0].getAttribute('category-count');

            if (id == 1) {
                $('#articleAlert').html('Bu kategori silinemez');
                $('#deleteButton').hide();
                return;
            }

            $('#delete-id').val(id);
            if (count > 0) {
                $('#articleAlert').html("Bu kategoriye ait " + count + " makaleyi ve kategoriyi istediğinizden emin misiniz?");
                $('#deleteButton').show();
            } else {
                $('#articleAlert').html("Bu kategoriyi silmek istediğinizden emin misiniz?");
                $('#deleteButton').show();
            }
        });
    });

    $(function() {
        $('.edit-click').click(function() {
            id = $(this)[0].getAttribute('category-id');
            $.ajax({
                type: 'GET',
                url: "{{route('admin.category.get')}}",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#category').val(data.name);
                    $('#slug').val(data.slug);
                    $('#category_id').val(data.id);
                    //$('#editModal').modal('show');
                }
            });
        });
    });


    $(function() {

        $('.switch').change(function() {

            id = $(this)[0].getAttribute('category-id');
            statu = $(this).prop('checked');
            $.get("{{route('admin.category.switch')}}", {
                id: id,
                statu: statu
            }, function(data, status) {
                console.log(data);
            })
        })
    })
</script>
@endsection
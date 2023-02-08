@extends('admin.admin_dashboard')
@section('admin')  

<div class="page-content"> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Adicionar Marca</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" title="Dashboard"><i class="lni lni-dashboard"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Adicionar Marca</li>
                </ol>
            </nav>
        </div>        
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">                
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{route('store.brand')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Nome</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="brand_name" class="form-control" value="" />
                                    </div>
                                </div>                                
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Imagem</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" name="brand_image" class="form-control" id="image" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0"></h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <img id="showImage" src="{{ url('upload/no_image.jpg')}}" alt="Marca" style="width: 100px; height: 100px;">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Adicionar marca" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>

@endsection
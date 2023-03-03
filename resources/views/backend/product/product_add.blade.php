@extends('admin.admin_dashboard')
@section('admin')  

<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Loja</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Novo Produto</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body p-4">
            <h5 class="card-title">Add Novo Produto</h5>
            <hr/>
            <div class="form-body mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="border border-3 p-4 rounded">
                            <div class="mb-3">
                                <label for="inputProductTitle" class="form-label">Nome do produto</label>
                                <input type="text" name="product_name" class="form-control" id="inputProductTitle" placeholder="Nome do produto">
                            </div>
                            <div class="mb-3">
                                <label for="inputProductTitle" class="form-label">Tags do produto</label>
                                <input type="text" name="product_tags" class="form-control visually-hidden" data-role="tagsinput" value="novo produto,produto top">
                            </div>
                            <div class="mb-3">
                                <label for="inputProductTitle" class="form-label">Tamanho do produto</label>
                                <input type="text" name="product_size" class="form-control visually-hidden" data-role="tagsinput" value="Pequeno, Médio, Grande">
                            </div>
                            <div class="mb-3">
                                <label for="inputProductTitle" class="form-label">Cor do produto</label>
                                <input type="text" name="product_color" class="form-control visually-hidden" data-role="tagsinput" value="Vermelho, Azul, Preto">
                            </div>
                            <div class="mb-3">
                                <label for="inputProductDescription" class="form-label">Descrição curta</label>
                                <textarea name="short_description" class="form-control" id="inputProductDescription" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="inputProductDescription" class="form-label">Descrição Completa</label>
                                <textarea name="long_description" id="long_description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" name="product_thambnail" class="form-label">Imagem principal</label>
                                <input class="form-control" type="file" id="formFile" onchange="mainThamUrl(this)">
                                <img src="" id="mainThumb" alt="">
                            </div>
                            <div class="mb-3">
                                <label for="formFile" name="multi_img[]" class="form-label">Multiplas imagens</label>
                                <input class="form-control" type="file" id="multiImg" multiple>
                                <div class="row" id="preview_img"></div>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="border border-3 p-4 rounded">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="inputPrice" class="form-label">Preço</label>
                                    <input type="text" class="form-control" id="selling_price" placeholder="00.00">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputCompareatprice" class="form-label">Desconto</label>
                                    <input type="text" name="discount_price" class="form-control" id="inputCompareatprice" placeholder="00.00">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputCostPerPrice" class="form-label">Código</label>
                                    <input type="text" name="product_code" class="form-control" id="inputCostPerPrice" placeholder="00.00">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputStarPoints" class="form-label">Quantidade</label>
                                    <input type="text" name="product_qty" class="form-control" id="inputStarPoints" placeholder="00.00">
                                </div>
                                <div class="col-12">
                                    <label for="inputProductType" class="form-label">Marca</label>
                                    <select name="brand_id" class="form-select" id="inputProductType">
                                        <option>...</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->brand_name}}</option>                                            
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="inputVendor" class="form-label">Categoria</label>
                                    <select name="category_id" class="form-select" id="inputVendor">
                                        <option>...</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->category_name}}</option>                                            
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="inputCollection" class="form-label">SubCategoria</label>
                                    <select name="subcategory_id" class="form-select" id="inputCollection">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="inputCollection" class="form-label">Selecione o fornecedor</label>
                                    <select name="vendor_id" class="form-select" id="inputCollection">
                                        <option>...</option>
                                        @foreach ($activeVendor as $vendor)
                                            <option value="{{$vendor->id}}">{{$vendor->name}}</option>                                            
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="hot_deals" type="checkbox" value="1" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">Ofertas quentes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="feature" type="checkbox" value="1" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">Destaque</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="special_offer" type="checkbox" value="1" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">Oferta especial</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" name="special_deals" type="checkbox" value="1" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">Ofertas especiais</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary">Save Product</button>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div><!--end row-->
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#multiImg').on('change', function(){ //on file input change
            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                var data = $(this)[0].files; //this file data
                
                $.each(data, function(index, file){ //loop though each file
                    if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                        var fRead = new FileReader(); //new filereader
                        fRead.onload = (function(file){ //trigger function on successful read
                        return function(e) {
                            var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                        .height(80); //create image element 
                            $('#preview_img').append(img); //append image to output element
                        };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.
                    }
                });
                
            }else{
                alert("Your browser doesn't support File API!"); //if File API is absent
            }
        });
    });
    function mainThamUrl(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#mainThumb').attr('src',e.target.result).width(80).height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).ready(function(){
        $('select[name="category_id"]').on('change', function(){
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: "{{url('subcategoria/ajax')}}/"+category_id,
                    tipe: "GET",
                    dataType: "json",
                    success: function(data){
                        $('select[name="subcategory_id"]').html('');
                        var d = $('select[name="subcategory_id"]').empty();
                        $.each(data, function(key, value){
                            console.log(value);
                            $('select[name="subcategory_id"]').append('<option value="'+value.id+'">'+value.subcategory_name+'</option>');
                        });
                    },
                });
            }else{
                alert('danger')
            }
        });
    });
    
  
 </script>
@endsection
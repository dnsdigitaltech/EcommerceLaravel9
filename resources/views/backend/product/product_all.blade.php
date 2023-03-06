@extends('admin.admin_dashboard')
@section('admin')  
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Todos os produtos</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Todos os produtos</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{route('add.product')}}" class="btn btn-primary">Add Produto</a>                    
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <hr/>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>S1</th>
                                <th>Imagem</th>
                                <th>Nome do produto</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                                <th>Desconto</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $key => $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td><img src="{{asset($item->product_thambnail)}}" style="width: 70px; height: 40px;"></td>
                                    <td>{{$item->product_name}}</td>
                                    <td>{{$item->product_price}}</td>
                                    <td>{{$item->product_qty}}</td>
                                    <td>
                                        @if ($item->discount_price == NULL)
                                            <span class="badge rounded-pill bg-info"> Sem</span>
                                        @else
                                            @php
                                                 $amount = $item->selling_price - $item->discount_price;
                                                 $dicount = ($amount/$item->selling_price) * 100;
                                            @endphp
                                            <span class="badge rounded-pill bg-danger"> {{round($dicount)}}%</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 1 )
                                          <span class="badge rounded-pill bg-success"> Ativo</span> 
                                        @else                                            
                                            <span class="badge rounded-pill bg-danger"> Inativo</span> 
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('edit.category', $item->id)}}" class="btn btn-info" title="Editar dado"><i class="fa-solid fa-pen-to-square"></i></i></a>
                                        <a href="{{route('delete.category', $item->id)}}" class="btn btn-danger" id="delete" title="Remover dado"><i class="fa-solid fa-trash"></i></a>
                                        <a href="{{route('delete.category', $item->id)}}" class="btn btn-secondary" title="Detalhes"><i class="fa-solid fa-circle-info"></i></a>
                                        @if ($item->status == 1 )
                                            <a href="{{route('delete.category', $item->id)}}" class="btn btn-primary" title="Inativo"><i class="fa-solid fa-thumbs-down"></i></a>
                                        @else
                                            <a href="{{route('delete.category', $item->id)}}" class="btn btn-primary" title="Ativo"><i class="fa-solid fa-thumbs-up"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S1</th>
                                <th>Imagem</th>
                                <th>Nome do produto</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                                <th>Desconto</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
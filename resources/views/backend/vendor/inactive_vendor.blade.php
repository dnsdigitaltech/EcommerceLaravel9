@extends('admin.admin_dashboard')
@section('admin')  
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Todos fornecedores inativos</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Fornecedores inativos</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    
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
                                <th>Nome da Loja</th>
                                <th>Nome de usuário</th>
                                <th>Data de filiação</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inActiveVendor as $key => $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->username}}</td>
                                    <td>{{$item->vendor_join}}</td>
                                    <td>{{$item->email}}</td>
                                    <td><span class="btn btn-secondary">{{$item->status}}</span></td>
                                    <td>
                                        <a href="{{route('inactive.vendor.details', $item->id)}}" class="btn btn-info">Detalhe do fornecedor</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S1</th>
                                <th>Nome da Loja</th>
                                <th>Nome de usuário</th>
                                <th>Data de filiação</th>
                                <th>Email</th>
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
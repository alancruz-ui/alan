@extends('admin.master')
@section('title','Products')
@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url('/admin/products')}}"><i class="fas fa-box-open"></i>Productos</a>
</li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fas fa-box-open"></i>Productos</h2>
        </div>
        <div class="inside">
           
             <div class="botones">
                 <a href="{{url('/admin/products/add')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i>añadir productos</a>
             </div>
            <table class="table table-striped mtop16">
               <thead>    
               <tr>
                   <td>ID</td>
                   <td></td>
                   <td>Nombre</td>
                   <td>Categoria</td>
                   <td>Precio</td>
                   <td></td>
               </tr>
               </thead>
               <tbody>
                   @foreach($products as $p)
                   <tr>
                       <td>{{$p->id}}</td>
                       <td></td>
                       <td>{{$p->name}}</td>
                       <td></td>
                       <td>{{$p->price}}</td>
                       <td></td>
                   </tr>
                   @endforeach
               </tbody>
                
            </table>
        </div>
    </div>
</div>
@endsection
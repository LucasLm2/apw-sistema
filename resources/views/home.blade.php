@extends('layouts.app')

@section('content')
<div class="container d-none">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100 shadow border-0">
                <div class="card-body">
                    <h5 class="card-title">Cadastros</h5>
                    <a href="{{ route('cliente.index') }}" class="card-link">Cliente</a>
                    <a href="{{ route('fornecedor.index') }}" class="card-link">Fornecedor</a>
                    <a href="{{ route('produto.index') }}" class="card-link">Produto</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 shadow border-0">
                <div class="card-body">
                    <h5 class="card-title">Financeiro</h5>
                    <a href="" class="card-link">Venda</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('adminlte::page')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-secondary">
                <div class="card-header">
                    {{ Form::open(['route' => 'import', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                        {{ csrf_field() }}
                        <input type="file" id="csv" name="csv" accept="text/csv" class="pull-left">
                        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-upload"></i> Importar CSV</button>
                    {{ Form::close() }}
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>CPF</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Data de Nascimento</th>
                            <th>CEP</th>
                            <th>Logradouro</th>
                            <th>Número</th>
                            <th>Complemento</th>
                            <th>Bairro</th>
                            <th>Cidade</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td>{{ StringHelper::mask($cliente->cpf, '###.###.###-##') }}</td>
                                <td>{{ $cliente->nome }}</td>
                                <td>{{ $cliente->email }}</td>
                                <td>{{ DateHelper::formatDate($cliente->data_nascimento) }}</td>
                                <td>{{ StringHelper::mask($cliente->endereco->cep, '#####-###') }}</td>
                                <td>{{ $cliente->endereco->logradouro }}</td>
                                <td>{{ $cliente->endereco->numero }}</td>
                                <td>{{ $cliente->endereco->complemento ?? '-' }}</td>
                                <td>{{ $cliente->endereco->bairro }}</td>
                                <td>{{ $cliente->endereco->cidade }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">Não há dados</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="container-fluid">
                            {!! PaginateHelper::paginateWithParams($clientes, []) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="container-fluid">
                            <a href="{{ route('export') }}" class="btn btn-success pull-left"><i class="fa fa-download"></i> Exportar para CSV</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

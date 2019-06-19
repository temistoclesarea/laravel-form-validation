@extends('layouts.layout')

@section('content')
    <h3>Novo cliente</h3>

    <a class="btn btn-secondary my-2" href="{{ route('clients.index') }}">Lista de Clientes</a><br>

    <h4>{{$clientType == \App\Client::TYPE_INDIVIDUAL ? 'Pessoa Física':'Pessoa Júridica'}}</h4>

    <a class="btn btn-primary my-2" href="{{route('clients.create', ['client_type' => \App\Client::TYPE_INDIVIDUAL])}}">Pessoa Física</a>
    <a class="btn btn-primary my-2" href="{{route('clients.create', ['client_type' => \App\Client::TYPE_LEGAL])}}">Pessoa Juridica</a>

    @include('form._form_errors')

    <form method="post" action="{{ route('clients.store') }}">

        @include('admin.clients._form')

        <button type="submit" class="btn btn-default">Criar</button>
    </form>
@endsection

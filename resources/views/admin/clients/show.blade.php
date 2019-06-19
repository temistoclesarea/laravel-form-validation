@extends('layouts.layout')

@section('content')
    <h3>Ver cliente</h3>
    <a class="btn btn-secondary my-2" href="{{ route('clients.index') }}">Lista de Clientes</a><br>
    <a class="btn btn-primary my-2" href="{{ route('clients.edit',['client' => $client->id]) }}">Editar</a>
    <a class="btn btn-danger my-2" href="{{ route('clients.destroy',['client' => $client->id]) }}"
        onclick="event.preventDefault(); if(confirm('Deseja excluir este item?')){document.getElementById('form-delete').submit();}">Excluir</a>
    <form id="form-delete" class="d-none" action="{{ route('clients.destroy',['client' => $client->id]) }}" method="post">
        {{--csrf_field()--}}
        @csrf
        {{--method_field('DELETE')--}}
        @method('DELETE')
    </form>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th scope="row">ID</th>
            <td>{{$client->id}}</td>
        </tr>
        <tr>
            <th scope="row">Nome</th>
            <td>{{$client->name}}</td>
        </tr>
        <tr>
            <th scope="row">Documento</th>
            <td>{{$client->document_number}}</td>
        </tr>
        <tr>
            <th scope="row">E-mail</th>
            <td>{{$client->email}}</td>
        </tr>
        <tr>
            <th scope="row">Telefone</th>
            <td>{{$client->phone}}</td>
        </tr>
        <tr>
            <th scope="row">Estado Civil</th>
            <td>
                @switch($client->marital_status)
                    @case(1)
                        Solteiro
                        @break

                    @case(2)
                        Casado
                        @break

                    @case(3)
                        Divorciado
                        @break
                @endswitch
            </td>
        </tr>
        <tr>
            <th scope="row">Data Nasc.</th>
            <td>{{$client->date_birth}}</td>
        </tr>
        <tr>
            <th scope="row">Sexo</th>
            <td>{{$client->sex == 'm' ? 'Masculino': 'Feminino'}}</td>
        </tr>
        <tr>
            <th scope="row">Def. Física</th>
            <td>{{$client->physical_disability}}</td>
        </tr>
        <tr>
            <th scope="row">Inadimplente</th>
            <td>{{$client->defaulter?'Sim': 'Não'}}</td>
        </tr>
        </tbody>
    </table>
@endsection

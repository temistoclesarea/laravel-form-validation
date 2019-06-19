@extends('layouts.layout')

@section('content')
    <h3>Editar cliente</h3>

    <a class="btn btn-secondary my-2" href="{{ route('clients.index') }}">Lista de Clientes</a>

    @include('form._form_errors')

    <form method="post" action="{{ route('clients.update',['client' => $client->id]) }}">

        <!--<input type="hidden" name="_method" value="PUT">-->
        {{-- method_field('PUT') --}}
        @method('PUT')

        @include('admin.clients._form')

        <button type="submit" class="btn btn-default">Alterar</button>
    </form>
@endsection

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;

class ClientsController extends Controller //Controller Resource
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //var_dump(route('meu-nome'));
        $clients = Client::all();
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $clientType = Client::getClientType($request->client_type);
        return view('admin.clients.create', ['client' => new Client(), 'clientType' => $clientType]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$client = new Client();
        $client->name = $request->get('name');
        $client->save();*/
        //$this->_validate($request);
        //$data = $request->all();

        $data = $this->_validate($request);
        $data['defaulter'] = $request->has('defaulter');
        $data['client_type'] = Client::getClientType($request->client_type);
        Client::create($data);
        //return redirect()->to('/admin/clients');
        return redirect()->route('clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('admin.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client) // Route Model Binding Implicito - Explicito
    {
        //$client = Client::findOrFail($client);
        $clientType = $client->client_type;
        return view('admin.clients.edit', compact('client', 'clientType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //$client = Client::findOrFail($id);
        //$this->_validate($request);
        //$data = $request->all();

        $data = $this->_validate($request);
        $data['defaulter'] = $request->has('defaulter');
        $client->fill($data);
        $client->save();
        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index');
    }

    protected function _validate(Request $request)
    {
        $clientType = Client::getClientType($request->client_type);
        $documentNumberType = $clientType == Client::TYPE_INDIVIDUAL ? 'cpf' : 'cnpj';
        $client = $request->route('client');
        $clientId = $client instanceof Client ? $client->id : null;
        $rules = [
            'name' => 'required|max:255',
            'document_number' => "required|unique:clients,document_number,$clientId|document_number:$documentNumberType",
            'email' => 'required|email',
            'phone' => 'required',
        ];
        $maritalStatus = implode(',', array_keys(Client::MARITAL_STATUS));
        $rulesIndividual = [
            'date_birth' => 'required|date',
            'marital_status' => "required|in:$maritalStatus",
            'sex' => 'required|in:m,f',
            'physical_disability' => 'max:255'
        ];
        $rulesLegal = [
            'company_name' => 'required|max:255'
        ];
        return $this->validate($request, $clientType == Client::TYPE_INDIVIDUAL ?
            $rules + $rulesIndividual : $rules + $rulesLegal);
    }
}

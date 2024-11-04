<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\ClientResource;
use App\Models\Classes;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)

    {   
        $clientsQuery = Client::search($request);
        $classes = ClassesResource::collection(Classes::all());

        //$this->applySearch($clientsQuery, $request->search);

        $clients = ClientResource::collection(
            $clientsQuery->paginate(10));

        return inertia ('Clients/index',[
            'clients' => $clients,
            'classes' => $classes,
            'search' => $request->search ?? '',
        ]);
    }  


    public function create()
    {

        $classes = ClassesResource::collection(Classes::all());

        return inertia('Clients/Create', [           
            'classes' => $classes,
        ]);

    }

    public function store (StoreClientRequest $request)
    {
        Client::create($request->validated());

        return redirect()->route('clients.index');    

    }

    public function edit(Client $client)
    {
        $classes = ClassesResource::collection(Classes::all());

        return inertia('Clients/Edit', [

            'classes'=> $classes,

            'client' => ClientResource::make($client),
        ]);
    }

    public function update(UpdateClientRequest $request, Client $client)

    {
        $client->update($request->validated());

        return redirect()->route('clients.index');
    }

    public function destroy (Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index');
    }

}



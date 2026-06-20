<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Http\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{

       public function __construct(
        private ClientService $clientService
    ) {}

    public function store(StoreClientRequest $request)
    {
        try {

            $client = $this->clientService->create(
                $request->validated(),
                auth()->id()
            );

            return response()->json([
                'message' => 'Client created successfully',
                'data' => new ClientResource($client)
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to create client',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function update(UpdateClientRequest $request, int $id)
    {
        try {

            $client = $this->clientService->show(
                $id,
                auth()->id()
            );


            $client = $this->clientService->update(
                $client,
                $request->validated()
            );

            return response()->json([
                'message' => 'Client updated successfully',
                'data' => new ClientResource($client)
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to update client',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy(int $id)
    {
        try {

            $client = $this->clientService->show(
                $id,
                auth()->id()
            );

            $this->clientService->delete($client);

            return response()->json([
                'message' => 'Client deleted successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to delete client',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function show(int $id)
    {
        try {

            $client = $this->clientService->show(
                $id,
                auth()->id()
            );

            return response()->json([
                'data' => new ClientResource($client)
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Client not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
    public function index()
    {
        try {

            $clients = $this->clientService->index(
                auth()->id()
            );

            return ClientResource::collection(
                $clients
            );

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to retrieve clients',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

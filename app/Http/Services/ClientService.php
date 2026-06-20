<?php
namespace App\Http\Services;

use App\Exceptions\ResourceNotFoundException;
use App\Http\Repositories\ClientRepository;
use App\Models\Client;
use Illuminate\Validation\ValidationException;

class ClientService{

    public function __construct(protected ClientRepository $clientRepository){}

    public function create(array $data, int $userId): Client
    {
        $data['user_id'] = $userId;
        return $this->clientRepository->create($data);
    }

    public function update(Client $client, array $data): Client
    {

        $this->clientRepository
            ->update($client,$data);

        return $client->fresh();
    }

    public function delete(Client $client): void
    {

        $this->clientRepository->delete($client);
    }

    public function show(int $id, int $userId): Client
    {

        return $this->clientRepository
                ->findById($id,$userId)
            ?? throw new ResourceNotFoundException('client');
    }

    public function index(int $userId) {
        return $this->clientRepository->getAll($userId);
    }
}


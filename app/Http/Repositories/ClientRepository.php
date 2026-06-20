<?php
namespace App\Http\Repositories;

use App\Models\Client;

class ClientRepository{

    public function __construct(protected Client $model)
    {}

    public function create(array $array):Client{
        return $this->model->create($array);
    }

    public function update(Client $client,array $data): bool
    {
        return $client->update($data);
    }

    public function delete(Client $client): bool
    {
        return $client->delete();
    }

    public function findById(int $id,  int $userId): Client
    {
        return Client::whereKey($id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }
    public function getAll(int $userId) {
        return $this->model->where('user_id',$userId)->latest()->paginate();
    }
}

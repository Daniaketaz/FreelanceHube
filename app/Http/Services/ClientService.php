<?php
namespace App\Http\Services;

use App\Http\Repositories\ClientRepository;

class ClientService{

    public function __construct(protected ClientRepository $repo){}

    public function create(array $data){
        return $this->repo->create($data);
    }
    public function find($id){
        return $this->repo->find($id);
    }

    public function update(array $data){
        return  $this->repo->update($data);
    }
}


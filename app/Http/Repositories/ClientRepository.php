<?php
namespace App\Http\Repositories;

use App\Models\Client;

class ClientRepository{

    public function __construct(protected Client $model)
    {}

    public function create(array $array):Client{
        return $this->model->create($array);
    }

    public function find(string $id){
        return $this->model->find('id',$id)->first();
    }
    public function update(array $array){
        return $this->model->update($array);
    }
}

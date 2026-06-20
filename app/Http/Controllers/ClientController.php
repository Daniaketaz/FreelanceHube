<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{

       public function __construct(
        private AuthService $authService
    ) {}
    
    public function store(CresteClientRequest $request){


    }
    public function update(){}
    public function destroy(){}
    public function show(){}
    public function index(string $id){}
}

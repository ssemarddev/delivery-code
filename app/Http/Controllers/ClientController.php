<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    protected $model = Client::class;

    /**
     * Registra un nuevo cliente
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'between:3,100'],
            'address' => ['required'],
            // 'city_id' => ["exists:cities,id"],
            // 'phone' => ['unique:clients,phone'],
            'status' => ['boolean']
        ]);
        return parent::store($request);
    }

    /**
     * Actualiza un cliente existente
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int Id de la unidad de medida a actualizar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'between:3,100'],
            'address' => ['required'],
            // 'city_id' => ["exists:cities,id"],
            // 'phone' => ["unique:clients,phone,$id"],
            'status' => ['boolean']
        ]);
        return parent::update($request, $id);
    }
}

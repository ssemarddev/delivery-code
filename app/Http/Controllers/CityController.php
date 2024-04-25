<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Validation\ValidationException;

class CityController extends Controller
{

    protected $model = City::class;

    /**
     * Registra una nueva unidad de medida
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'between:3,60'],
            'province' => ['required', 'between:3,60'],
            'status' => ['filled', 'boolean'],
        ]);
        $city = City::where('name', $request->name)->where('province', $request->province)->first();
        if ($city != null && $city->exists()) {
            throw ValidationException::withMessages([
                'name' => ["Esta ciudad y esta región ya fue registrada"],
            ]);
        }
        return parent::store($request);
    }

    /**
     * Registra una nueva unidad de medida
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id Id de la unidad de medida a actualizar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'between:3,60'],
            'province' => ['required', 'between:3,60'],
            'status' => ['filled', 'boolean'],
        ]);
        $city = City::where('name', $request->name)->where('province', $request->province)->first();
        if ($city != null && $city->exists()) {
            if ($city->id != $id) {
                throw ValidationException::withMessages([
                    'name' => ["Esta ciudad y esta región ya fue registrada"],
                ]);
            }
        }
        return parent::update($request, $id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{

    protected $model = Provider::class;

    /**
     * Registra una nueva unidad de medida
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'between:3,60', "unique:providers,name"],
            // 'email' => ['email', 'between:3,100', "unique:providers,email"],
            // 'address' => ['between:5,150'],
            // 'phone' => ['between:5,20', "unique:providers,phone"],
            'status' => ['boolean'],
        ]);
        return parent::store($request);
    }

    /**
     * Registra una nueva unidad de medida
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int Id de la unidad de medida a actualizar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'between:3,60', "unique:providers,name,$id"],
            // 'email' => ['email', 'between:3,100', "unique:providers,email,$id"],
            // 'address' => ['between:5,150'],
            // 'phone' => ['between:5,20', "unique:providers,phone,$id"],
            'status' => ['boolean'],
        ]);
        return parent::update($request, $id);
    }
}

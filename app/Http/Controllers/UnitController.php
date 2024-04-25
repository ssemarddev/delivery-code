<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Unit;

class UnitController extends Controller
{

    protected $model = Unit::class;

    /**
     * Registra una nueva unidad de medida
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'between:3,60', "unique:units,name"],
            'status' => ['required', 'boolean']
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
            'name' => ['required', 'between:3,60', "unique:units,name,$id"],
            'status' => ['required', 'boolean']
        ]);
        return parent::update($request, $id);
    }
}

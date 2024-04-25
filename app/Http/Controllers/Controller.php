<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Model associated with controller
     */
    protected $model;

    /**
     * Obtener lista de registros
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->model::all());
    }

    /**
     * Obtener lista de registros
     *
     * @return \Illuminate\Http\Response
     */
    public function last($page)
    {
        $skip = $page * 50;
        $items = $this->model::latest()->skip($skip)->take(50)->get();
        return response()->json($items);
    }

    /**
     * Crea un nuevo registro en la base de datos
     *
     * @return \Illuminate\Http\Response Los datos del nuevo registro
     */
    public function store(Request $request)
    {
        //Crear la instancia del modelo en la base de datos
        $data = $request->all();
        $item = $this->model::create($data);
        //Retornar el nuevo modelo
        return response()->json($item);
    }

    /**
     * Actualiza un registro de la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id Id del registro a actualizar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Obtener datos de la petición
        $data = $request->except(['_method']);
        //Actualizar el modelo
        $this->model::where('id', $id)->update($data);
        //Retornar el nuevo modelo
        $item = $this->model::find($id);
        return response()->json($item);
    }

    /**
     * Eliminar registros de la base de datos a partir de los ids pasados en la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Obtener ids
        $ids = Str::of($request->ids)->explode(',');
        //Eliminar los modelos
        $this->model::ids($ids)->delete();
        //Retornar respuesta
        return response('', 200);
    }

    /**
     * Actualiza varios registros a la vez
     *
     * @param  array  $ids Ids de los registros a actualizar
     * @param  array $data Nuevos datos de los registros
     * @return \Illuminate\Http\Response
     */
    public function updateMultipleRows($ids, $data)
    {
        //Actualizar los registros
        $this->model::ids($ids)->update($data);
        //Retornar código de estado 200
        return response('', 200);
    }
}

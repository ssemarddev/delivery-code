<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FundController extends Controller
{

    protected $model = Fund::class;

    /**
     * Obtener lista de registros
     *
     * @return \Illuminate\Http\Response
     */
    public function last($page)
    {
        $skip = $page * 5;
        $items = $this->model::latest('start')->skip($skip)->take(5)->get();
        return response()->json($items);
    }

    public function latest(Request $request) {
        $items = Fund::where('user_id', $request->user()->id)->latest('start')->take(1)->get();
        return response()->json($items);
    }

    /**
     * Registra una nueva categoría
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'initial' => [
                'required',
                // 'regex:/^[\d.]+$/'
            ],
        ]);
        $fund = DB::table('funds')->where('user_id', $request->user()->id)->latest('start')->first();
        if ($fund && $fund->end == null) {
            throw ValidationException::withMessages([
                'user_id' => ["Ya has abierto caja"],
            ]);
        }
        //Crear la instancia del modelo en la base de datos
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $data['start'] = Carbon::now();
        $item = Fund::create($data);
        //Retornar el nuevo modelo
        return response()->json($item);
    }

    /**
     * Registra una nueva categoría
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int Id de la categoría a actualizar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'current' => [
                'required',
                // 'regex:/^[\d.]+$/'
            ],
        ]);
        //Obtener datos de la petición
        $data = $request->except(['_method']);
        $data['end'] = Carbon::now();
        //Actualizar el modelo
        $fund = Fund::find($id);
        if ($request->user()->id == $fund->user_id) {
            if ($fund->user_id != $request->user()->id) {
                throw ValidationException::withMessages([
                    'status' => ["No tienes permiso para realizar esta operación"],
                ]);
            }
            $fund->update($data);
            return response()->json($fund);
        } else {
            throw ValidationException::withMessages([
                'user_id' => ["No tienes autorización para cerrar la caja de otro usuario"],
            ]);
        }
    }

    public function open(Request $request, $id)
    {
        if ($request->user()->role == 'Administrador') {
            $fund = Fund::find($id);
            $fund->update(['end' => null, 'current' => null]);
            return response()->json($fund);
        } else {
            throw ValidationException::withMessages([
                "user" => ["Solo el administrador puede eliminar pedidos"],
            ]);
        }
    }
}

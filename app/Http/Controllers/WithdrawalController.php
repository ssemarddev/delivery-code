<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{

    protected $model = Withdrawal::class;

    /**
     * Registra una nueva categoría
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'concept' => ['required', 'between:3,255'],
            'quantity' => ['required', 'regex:/^[\d.]+$/'],
        ]);

        //Crear la instancia del modelo en la base de datos
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $item = Withdrawal::create($data);
        //Retornar el nuevo modelo
        return response()->json($item);
    }
}

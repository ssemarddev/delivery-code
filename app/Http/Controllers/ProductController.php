<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    protected $model = Product::class;

    /**
     * Obtener lista de registros
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Product::where('removed', 0)->get());
    }

    /**
     * Registra una nueva unidad de medida
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'between:3,60'],
            'cost' => ['required', 'regex:/^[\d.]+$/', 'between:1,12'],
            'price' => ['required', 'regex:/^[\d.]+$/', 'between:1,12'],
            'stock' => ['required', 'integer'],
            'min' => ['required', 'integer'],
            'manage_stock' => ['boolean'],
            'status' => ['required', 'boolean'],
        ]);
        $data = $request->except(['_method', 'offers']);
        $data['user_id'] = $request->user()->id;
        $item = $this->model::create($data);
        if ($request->has('offers')) {
            foreach ($request->offers as $offer) {
                Offer::create([
                    'product_id' => $item->id,
                    'quantity' => $offer['quantity'],
                    'price' => $offer['price'],
                ]);
            }
        }
        $item->refresh();
        //Retornar el nuevo modelo
        return response()->json($item);
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
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'between:3,60'],
            'cost' => ['required', 'regex:/^[\d.]+$/', 'between:1,12'],
            'price' => ['required', 'regex:/^[\d.]+$/', 'between:1,12'],
            'stock' => ['required', 'integer'],
            'min' => ['required', 'integer'],
            'manage_stock' => ['boolean'],
            'status' => ['required', 'boolean'],
        ]);
        //Obtener datos de la petición
        $data = $request->except(['_method', 'offers']);
        //Actualizar el modelo
        $this->model::where('id', $id)->update($data);
        Offer::where('product_id', $id)->delete();
        if ($request->has('offers')) {
            foreach ($request->offers as $offer) {
                Offer::create([
                    'product_id' => $id,
                    'quantity' => $offer['quantity'],
                    'price' => $offer['price'],
                ]);
            }
        }
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
        $this->model::ids($ids)->update(['removed' => 1]);
        //Retornar respuesta
        return response('', 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{

    protected $model = Purchase::class;

    /**
     * Registra una nueva unidad de medida
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'provider_id' => ['required', 'exists:providers,id'],
            'file' => ['required'],
            'file_type' => ['filled', 'in:Comprobante,Boleta,Factura'],
        ]);
        $data = $request->except(['_method', 'items', 'payments', 'image']);
        $data['number'] = substr(Str::uuid(), 0, 10);
        $data['user_id'] = $request->user()->id;
        if ($request->has('image')) {
            $image = $request->input('image');
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $name = time() . '.png';
            Storage::disk('src')->put("purchases/$name", base64_decode($image));
            $data['annex'] = "purchases/$name";
        }
        $purchase = $this->model::create($data);
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                $product->update(['stock' => $product->stock + $item['quantity']]);
            } else {
                $purchase->delete();
                throw ValidationException::withMessages([
                    $item['product_id'] => ["No existe el producto en la base de datos"],
                ]);
            }
        }
        foreach ($request->payments as $payment) {
            Payment::create([
                'purchase_id' => $purchase->id,
                'pay_type' => $payment['pay_type'],
                'payed' => $payment['payed'],
            ]);
        }
        $purchase->refresh();
        //Retornar el nuevo modelo
        return response()->json($purchase);
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
            'provider_id' => ['required', 'exists:providers,id'],
            'file' => ['required'],
            'file_type' => ['filled', 'in:Comprobante,Boleta,Factura'],
        ]);
        $purchase = Purchase::find($id);
        //Obtener datos de la petición
        $data = $request->except(['_method', 'items', 'payments', 'image']);
        foreach ($purchase->items as $item) {
            $product = Product::find($item->product_id);
            $product->update(['stock' => ($product->stock - $purchase->stock($product->id))]);
        }
        PurchaseItem::where('purchase_id', $id)->delete();
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            PurchaseItem::create([
                'purchase_id' => $id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            $product->update(['stock' => $product->stock + $item['quantity']]);
        }
        Payment::where('purchase_id', $id)->delete();
        foreach ($request->payments as $payment) {
            Payment::create([
                'purchase_id' => $id,
                'pay_type' => $payment['pay_type'],
                'payed' => $payment['payed'],
            ]);
        }
        if ($request->has('image')) {
            $image = $request->input('image');
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $name = time() . '.png';
            Storage::disk('src')->put("purchases/$name", base64_decode($image));
            $data['annex'] = "purchases/$name";
        }
        $purchase->update($data);
        //Retornar el nuevo modelo
        $purchase->refresh();
        return response()->json($purchase);
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
        foreach ($ids as $id) {
            $purchase = Purchase::find($id);
            foreach ($purchase->items as $item) {
                $product = Product::find($item->product_id);
                $product->update(['stock' => $product->stock - $item->quantity]);
            }
            $purchase->delete();
        }
        //Retornar respuesta
        return response('', 200);
    }
}

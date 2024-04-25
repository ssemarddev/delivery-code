<?php

namespace App\Http\Controllers;

use App\Models\ClientPayment;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{

    protected $model = Order::class;


    /**
     * Obtener lista de registros
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $items = Order::where('status', 'Listo')->orWhere('status', 'Pendiente')->latest()->get();
        return response()->json($items);
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
            'delivery_id' => ['filled', 'exists:users,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'grocer_id' => ['filled', 'exists:users,id'],
            'file' => ['filled', 'in:Comprobante,Boleta,Factura'],
            'status' => ['filled', 'in:Pendiente,Listo,Entregado,Cancelado'],
        ]);
        $fund = DB::table('funds')->where('user_id', $request->user()->id)->latest('start')->first();
        if (!$fund || $fund->end != null) {
            throw ValidationException::withMessages([
                "user_id" => ["Debes abrir caja primero para realizar una venta"],
            ]);
        }
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            if ($product->manage_stock && $product->stock < $item['quantity']) {
                throw ValidationException::withMessages([
                    $item['product_id'] => ["No existe la cantidad requerida en el stock del producto {$product->name}"],
                ]);
            }
        }
        $data = $request->except(['_method', 'items']);
        $data['user_id'] = $request->user()->id;
        $data['number'] = substr(Str::uuid(), 0, 10);
        $order = $this->model::create($data);
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            Item::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'note' => $item['note'],
            ]);
            $product->update(['stock' => $product->stock - $item['quantity']]);
        }
        $order->refresh();
        //Retornar el nuevo modelo
        return response()->json($order);
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
            'delivery_id' => ['filled', 'exists:users,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'grocer_id' => ['filled', 'exists:users,id'],
            'file' => ['filled', 'in:Comprobante,Boleta,Factura'],
            'status' => ['filled', 'in:Pendiente,Listo,Entregado,Cancelado'],
        ]);
        $order = Order::find($id);
        if (($order->status == 'Entregado' || $order->status == 'Cancelado') && $request->user()->role != 'Administrador') {
            throw ValidationException::withMessages([
                'order_id' => ["No es posible actualizar un pedido que ha sido {$order->status}"],
            ]);
        }
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            if ($product->manage_stock && ($product->stock + $order->stock($product->id)) < $item['quantity']) {
                throw ValidationException::withMessages([
                    $item['product_id'] => ["No existe la cantidad requerida en el stock del producto {$product->name}"],
                ]);
            }
        }
        //Obtener datos de la petición
        $data = $request->except(['_method', 'items']);
        //Actualizar el modelo
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            $product->update(['stock' => ($product->stock + $order->stock($product->id))]);
        }
        Item::where('order_id', $id)->delete();
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            Item::create([
                'order_id' => $id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'note' => $item['note'],
            ]);
            $product->update(['stock' => $product->stock - $item['quantity']]);
        }
        $order->update($data);
        $order->refresh();
        return response()->json($order);
    }

    public function status(Request $request, $id)
    {
        $order = Order::find($id);
        if ($request->user()->role != 'Administrador' && $order->status != 'Listo') {
            throw ValidationException::withMessages([
                'status' => ["No se puede marcar como pendiente este pedido porque ya ha sido entregado o cancelado"],
            ]);
        } else {
            if ($order->status == 'Cancelado') {
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    $product->update(['stock' => $product->stock - $item->quantity]);
                }
            }
            $data = ['status' => 'Pendiente'];
            $order->update($data);
            $order->refresh();
            return response()->json($order);
        }
    }

    public function ready(Request $request, $id)
    {
        $fund = DB::table('funds')->where('user_id', $request->user()->id)->latest('start')->first();
        if ($request->user()->role != 'Administrador' || !$fund || $fund->end != null) {
            throw ValidationException::withMessages([
                "user_id" => ["Debes abrir caja primero para preparar un pedido"],
            ]);
        }
        $order = Order::find($id);
        if ($request->user()->role != 'Administrador' || ($order->status == 'Entregado' || $order->status == 'Cancelado')) {
            throw ValidationException::withMessages([
                'status' => ["No se puede marcar como listo este pedido porque ya ha sido entregado o cancelado"],
            ]);
        } else {
            if ($order->status == 'Cancelado') {
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    $product->update(['stock' => $product->stock - $item->quantity]);
                }
            }
            $data = [
                'status' => 'Listo',
                'store_date' => Carbon::now(),
                'grocer_id' => $request->user()->id,
            ];
            $order->update($data);
            $order->refresh();
            return response()->json($order);
        }
    }

    public function deliver(Request $request, $id)
    {
        $fund = DB::table('funds')->where('user_id', $request->user()->id)->latest('start')->first();
        if (!$fund || $fund->end != null) {
            throw ValidationException::withMessages([
                "user_id" => ["Debes abrir caja primero para entregar un pedido"],
            ]);
        }
        $order = Order::find($id);
        $data = ['status' => 'Entregado', 'delivery_date' => Carbon::now()];
        if ($order->status != 'Listo') {
            throw ValidationException::withMessages([
                'status' => ["No se puede entregar este pedido porque aún no está listo en bodega"],
            ]);
        }
        if ($order->status == 'Entregado' || $order->status == 'Cancelado') {
            throw ValidationException::withMessages([
                'status' => ["No se puede entregar este pedido porque ya ha sido entregado o cancelado"],
            ]);
        }
        $data['delivery_id'] = $request->user()->id;
        $payment = [
            'pay_type' => $request->pay_type,
            'total' => $request->total,
            'rest' => $request->rest,
        ];
        switch ($request->pay_type) {
            case 'A crédito':
                $date = DateTime::createFromFormat("d/m/Y", $request->pay_date);
                $formated = $date->format("Y/m/d");
                $payment['pay_date'] = date('Y/m/d', strtotime($formated));
                $payment['status'] = 'Por pagar';
                break;
            case 'Transferencia':
            case 'Depósito':
                $payment['card'] = $request->card;
                if ($request->image != '') {
                    $image = $request->input('image');
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $name = time() . '.png';
                    Storage::disk('src')->put("orders/$name", base64_decode($image));
                    $payment['annex'] = "orders/$name";
                }
                $payment['status'] = 'Pagado';
                break;
            default:
                $payment['status'] = 'Pagado';
                break;
        }
        $payment = ClientPayment::create($payment);
        $data['client_payment_id'] = $payment->id;
        $order->update($data);
        $order->refresh();
        return response()->json($order);
    }

    public function cancel(Request $request, $id)
    {
        $fund = DB::table('funds')->where('user_id', $request->user()->id)->latest('start')->first();
        if (!$fund || $fund->end != null) {
            throw ValidationException::withMessages([
                "user_id" => ["Debes abrir caja primero para anular un pedido"],
            ]);
        }
        $order = Order::find($id);
        if ($order->status == 'Entregado') {
            throw ValidationException::withMessages([
                'status' => ["No se puede anular un pedido entregado"],
            ]);
        } else {
            $data['delivery_id'] = $request->user()->id;
            $data['status'] = 'Cancelado';
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                $product->update(['stock' => $product->stock + $item->quantity]);
            }
            $order->update($data);
            $order->refresh();
            return response()->json($order);
        }
    }

    public function charge(Request $request, $id)
    {
        $fund = DB::table('funds')->where('user_id', $request->user()->id)->latest('start')->first();

        if ($request->user()->role != 'Administrador' && (!$fund || $fund->end != null)) {
            throw ValidationException::withMessages([
                "user_id" => ["Debes abrir caja primero para realizar el cobro de un pedido"],
            ]);
        }
        $order = Order::find($id);
        $annex = null;
        if ($request->final_pay_type != 'Efectivo' && $request->image != '') {
            $image = $request->input('image');
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $name = time() . '.png';
            Storage::disk('src')->put("orders/$name", base64_decode($image));
            $annex = "orders/$name";
        }
        $order->payment()->update([
            'user_id' => $request->user()->id,
            'status' => 'Pagado',
            'charged_at' => Carbon::now(),
            'final_pay_type' => $request->final_pay_type,
            'total' => $request->total,
            'rest' => $request->final_pay_type == 'Efectivo' ? $request->rest : null,
            'card' => $request->final_pay_type == 'Efectivo' ? null : $request->card,
            'annex' => $annex,
        ]);
        $order->refresh();
        return response()->json($order);
    }

    /**
     * Eliminar registros de la base de datos a partir de los ids pasados en la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->user()->role == 'Administrador') {
            //Obtener ids
            $ids = Str::of($request->ids)->explode(',');
            foreach ($ids as $id) {
                $order = Order::find($id);
                if ($order->status != 'Cancelado') {
                    foreach ($order->items as $item) {
                        $product = Product::find($item->product_id);
                        $product->update(['stock' => $product->stock + $item->quantity]);
                    }
                }
                $order->delete();
            }
            //Retornar respuesta
            return response('', 200);
        } else {
            throw ValidationException::withMessages([
                "user" => ["Solo el administrador puede eliminar pedidos"],
            ]);
        }
    }
}

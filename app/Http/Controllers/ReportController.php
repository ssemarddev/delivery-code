<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class ReportController extends BaseController
{

    public function purchase($ids, $user)
    {
        $ids = explode(',', $ids);
        $purchases = [];
        $total = 0;
        $items = 0;
        foreach ($ids as $id) {
            $purchase = Purchase::find($id);
            if ($purchase) {
                $purchases[] = $purchase;
                $total += $purchase->totalPrice();
                $items += $purchase->totalItems();
            }
        }
        $dompdf = App::make("dompdf.wrapper");
        $dompdf->loadView("purchases", [
            "purchases" => $purchases,
            "total" => $total,
            "items" => $items,
            "user" => User::find($user)->first(),
        ]);
        return $dompdf->stream();
    }

    public function seller($ids, $user)
    {
        $ids = explode(',', $ids);
        $orders = [];
        foreach ($ids as $id) {
            $order = Order::find($id);
            $orders[] = $order;
        }
        if (true) {
            $total = 0;
            $items = 0;
            $date = "";
            $cities = [];
            foreach ($orders as $order) {
                if ($date == "" || Carbon::parse($date) < Carbon::parse($order->created_at)) {
                    $date = $order->created_at;
                }
                if (!isset($cities[$order->client->city->province]) || !isset($cities[$order->client->city->province][$order->client->city->name])) {
                    $cities[$order->client->city->province] = [$order->client->city->name];
                }
                $items += $order->totalItems();
                $total += $order->totalPrice();
            }
            usort($orders, function($a, $b) {
                return $a->client->city->province > $b->client->city->province;
            });
            $regions = [];
            foreach ($cities as $province => $city) {
                $regions[] = "{$province}";
            }
            $regions = implode(", ", $regions);
            $days = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
            $date = $days[date('w', strtotime($date) - 18000)] . ", " . date('d/m/Y', strtotime($date) - 18000);
            $dompdf = App::make("dompdf.wrapper");
            $dompdf->loadView("seller-orders", [
                "orders" => $orders,
                "total" => $total,
                "items" => $items,
                "date" => $date,
                "regions" => $regions,
                "user" => User::find($user)->first(),
                "print" => $days[date('w', strtotime(now()) - 18000)] . ", " . date('d/m/Y', strtotime(now()) - 18000)
            ]);
        } else {
            $dompdf = App::make("dompdf.wrapper");
            $dompdf->loadView("empty");
        }
        return $dompdf->stream();
    }

    public function store($ids, $user)
    {
        $ids = explode(',', $ids);
        $orders = Order::ids($ids);
        if ($orders != null && $orders->exists()) {
            $items = [];
            $total = 0;
            $current = 0;
            $sales = 0;
            $date = "";
            $cities = [];
            foreach ($orders->get() as $order) {
                if ($date == "" || Carbon::parse($date) < Carbon::parse($order->created_at)) {
                    $date = $order->created_at;
                }
                if (!isset($cities[$order->client->city->province]) || !isset($cities[$order->client->city->province][$order->client->city->name])) {
                    $cities[$order->client->city->province] = [$order->client->city->name];
                }
                foreach ($order->items as $item) {
                    if (isset($items[$item->product_id])) {
                        $items[$item->product_id]['quantity'] += $item->quantity;
                        $items[$item->product_id]['total'] += ($item->quantity * $item->price);
                    } else {
                        $items[$item->product_id] = [
                            'quantity' => $item->quantity,
                            'name' => $item->product->name,
                            'price' => $item->product->price,
                            'stock' => $item->product->stock,
                            'total' => ($item->quantity * $item->price),
                        ];
                    }
                    $current += $item->product->stock;
                    $total += $item->quantity;
                    $sales += $item->quantity * $item->price;
                }
            }
            $temp = [];
            foreach($items as $item) {
                $temp[] = $item;
            }
            $items = $temp;
            usort($items, function($a, $b) {
                return $a['name'] > $b['name'];
            });
            $regions = [];
            foreach ($cities as $province => $city) {
                // $joined = implode(",", $city);
                $regions[] = "{$province}";
            }
            $regions = implode(", ", $regions);
            $purchase = 0;

            foreach ($items as $item) {
                if ($item['stock'] - $item['quantity'] < 0) {
                    $purchase += $item['quantity'] - $item['stock'];
                }
            }

            $days = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
            $date = $days[date('w', strtotime($date) - 18000)] . ", " . date('d/m/Y', strtotime($date) - 18000);
            $dompdf = App::make("dompdf.wrapper");
            $dompdf->loadView("store-orders", [
                "orders" => $items,
                "total" => $total,
                "current" => $current,
                "purchase" => $purchase,
                "date" => $date,
                "regions" => $regions,
                "sales" => $sales,
                "user" => User::find($user)->first(),
                "print" => $days[date('w', strtotime(now()) - 18000)] . ", " . date('d/m/Y', strtotime(now()) - 18000)
            ]);
        } else {
            $dompdf = App::make("dompdf.wrapper");
            $dompdf->loadView("empty");
        }
        return $dompdf->stream();
    }

    public function delivery($ids, $user)
    {
        $ids = explode(',', $ids);
        $orders = [];
        foreach ($ids as $id) {
            $order = Order::find($id);
            $orders[] = $order;
        }

        if (true) {
            $total = 0;
            $items = 0;
            $date = "";
            $cities = [];
            foreach ($orders as $order) {
                if ($date == "" || Carbon::parse($date) < Carbon::parse($order->created_at)) {
                    $date = $order->created_at;
                }
                if (!isset($cities[$order->client->city->province]) || !isset($cities[$order->client->city->province][$order->client->city->name])) {
                    $cities[$order->client->city->province] = [$order->client->city->name];
                }
                $items += $order->totalItems();
                $total += $order->totalPrice();
            }
            $regions = [];
            foreach ($cities as $province => $city) {
                $regions[] = "{$province}";
            }
            $regions = implode(", ", $regions);
            $days = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
            $date = $days[date('w', strtotime($date) - 18000)] . ", " . date('d/m/Y', strtotime($date) - 18000);
            $dompdf = App::make("dompdf.wrapper");
            $dompdf->loadView("orders", [
                "orders" => $orders,
                "total" => $total,
                "items" => $items,
                "date" => $date,
                "regions" => $regions,
                "user" => User::find($user)->first(),
                "print" => $days[date('w', strtotime(now()) - 18000)] . ", " . date('d/m/Y', strtotime(now()) - 18000)
            ]);
        } else {
            $dompdf = App::make("dompdf.wrapper");
            $dompdf->loadView("empty");
        }
        return $dompdf->stream();
    }

    public function orders($ids, $user)
    {
        $user = User::find($user);
        $ids = explode(',', $ids);
        $orders = Order::ids($ids);
        if ($orders != null && $orders->exists()) {
            $totals = [];
            $dates = [];
            $days = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
            foreach ($orders->get() as $order) {
                $dates[] = $days[date('w', strtotime($order->created_at) - 18000)] . ", " . date('d/m/Y', strtotime($order->created_at) - 18000);
                $total = 0;
                foreach ($order->items as $item) {
                    $total += $item->quantity * $item->price;
                }
                $totals[] = $total;
            }
            $dompdf = App::make("dompdf.wrapper");
            $dompdf->loadView("client-orders", [
                "orders" => $orders->get(),
                "totals" => $totals,
                "dates" => $dates,
                "user" => $user,
            ])->setPaper([0, 0, 600, 496.133], 'landscape');
        } else {
            $dompdf = App::make("dompdf.wrapper");
            $dompdf->loadView("empty")->setPaper([0, 0, 600, 496.133], 'landscape');
        }
        return $dompdf->stream();
    }

    public function order($id)
    {
        $order = Order::find($id);
        if ($order != null && $order->exists()) {
            $total = 0;
            foreach ($order->items as $item) {
                $total += $item->quantity * $item->price;
            }
            $dompdf = App::make("dompdf.wrapper");
            $dompdf->loadView("order", [
                "order" => $order,
                "total" => $total,
            ]);
        } else {
            $dompdf = App::make("dompdf.wrapper");
            $dompdf->loadView("empty");
        }
        return $dompdf->stream();
    }
}

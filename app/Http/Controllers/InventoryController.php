<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

    public function index() {
        $orders = Order::whereDate('created_at', Carbon::today())->get();
        $products = [];
        foreach($orders as $order) {

        }
    }


}

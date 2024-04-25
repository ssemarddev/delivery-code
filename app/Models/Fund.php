<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fund extends Base
{

    /**
     * Indicar que el modelo no maneja columnas created_at y updated_at
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the user associated with the product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        switch ($this->user->role) {
            case 'Vendedor':
                return Order::where('user_id', $this->user_id)->where('created_at', '>=', $this->start)->where('created_at', '<', $this->end == null ? Carbon::now() : $this->end)->get();
            case 'Repartidor':
                return Order::where('delivery_id', $this->user_id)->where('delivery_date', '>=', $this->start)->where('delivery_date', '<', $this->end == null ? Carbon::now() : $this->end)->get();
            case 'Bodeguero':
                return Order::where('grocer_id', $this->user_id)->where('store_date', '>=', $this->start)->where('store_date', '<', $this->end == null ? Carbon::now() : $this->end)->get();
            default:
                return [];
        }
    }

    public function charges()
    {
        $items = ClientPayment::where('user_id', $this->user_id)->where('updated_at', '>=', $this->start)->where('updated_at', '<', $this->end == null ? Carbon::now() : $this->end)->get();
        $orders = [];
        foreach ($items as $item) {
            $orders[] = $item->order;
        }
        return $orders;
    }

    public function withdrawals()
    {
        $items = Withdrawal::where('user_id', $this->user_id)->where('created_at', '>=', $this->start)->where('created_at', '<', $this->end == null ? Carbon::now() : $this->end)->get();
        // $items = Withdrawal::where('user_id', $this->user_id)->where('created_at', '>=', $this->start)->get();
        return $items;
    }

    /**
     * Include relationship to array response
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->user) {
            $data['user'] = $this->user;
        } else {
            $data['user'] = null;
        }
        $data['orders'] = $this->orders();
        $data['charges'] = $this->charges();
        $data['withdrawals'] = $this->withdrawals();
        return $data;
    }
}

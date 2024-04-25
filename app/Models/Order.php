<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Base
{
    /**
     * Get the user associated with the product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user associated with the product.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the unit associated with the product.
     */
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delivery_id');
    }

    /**
     * Get the category associated with the product.
     */
    public function grocer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'grocer_id');
    }

    /**
     * Get the category associated with the product.
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(ClientPayment::class, 'client_payment_id');
    }

    /**
     * Gets offers associated with the product.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function stock($productId) {
        $stock = 0;
        foreach($this->items as $item) {
            if($item->product_id == $productId) {
                return $item->quantity;
            }
        }
        return $stock;
    }

    public function totalItems() {
        $total = 0;
        foreach($this->items as $item) {
            $total += $item->quantity;
        }
        return $total;
    }

    public function totalPrice() {
        $total = 0;
        foreach($this->items as $item) {
            $total += $item->quantity * $item->price;
        }
        return $total;
    }

    public function totalCost() {
        $total = 0;
        foreach($this->items as $item) {
            $total += $item->quantity * $item->cost;
        }
        return $total;
    }

    /**
     * Include relationship to array response
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->items) {
            $data['items'] = $this->items;
        } else {
            $data['items'] = [];
        }
        if ($this->user) {
            $data['user'] = $this->user;
        } else {
            $data['user'] = null;
        }
        if ($this->client) {
            $data['client'] = $this->client;
        } else {
            $data['client'] = null;
        }
        if ($this->delivery) {
            $data['delivery'] = $this->delivery;
        } else {
            $data['delivery'] = null;
        }
        if ($this->grocer) {
            $data['grocer'] = $this->grocer;
        } else {
            $data['grocer'] = null;
        }
        if ($this->payment) {
            $data['payment'] = $this->payment;
        } else {
            $data['payment'] = null;
        }
        return $data;
    }
}

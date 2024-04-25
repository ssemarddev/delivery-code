<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Base
{

    public function getAnnexPathAttribute()
    {
        if ($this->annex !== null) {
            return asset("src/$this->annex");
        } else {
            return asset("src/img/image-placeholder.jpg");
        }
    }

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
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }


    /**
     * Gets offers associated with the product.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    /**
     * Gets offers associated with the product.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
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

    public function stock($productId) {
        $stock = 0;
        foreach($this->items as $item) {
            if($item->product_id == $productId) {
                return $item->quantity;
            }
        }
        return $stock;
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
        if ($this->payments()) {
            $data['payments'] = $this->payments;
        } else {
            $data['payments'] = [];
        }
        if ($this->user) {
            $data['user'] = $this->user;
        } else {
            $data['user'] = null;
        }
        if ($this->provider) {
            $data['provider'] = $this->provider;
        } else {
            $data['provider'] = null;
        }
        $data['annex'] = $this->annexPath;
        return $data;
    }
}

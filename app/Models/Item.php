<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Base
{

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Include relationship to array response
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->product) {
            $data['product'] = $this->product;
        } else {
            $data['product'] = null;
        }
        return $data;
    }
}

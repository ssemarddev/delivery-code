<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ClientPayment extends Base
{

    public function getImagePathAttribute()
    {
        if ($this->annex !== null) {
            return asset("src/$this->annex");
        } else {
            return null;
        }
    }

    /**
     * Get the user associated with the product.
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    /**
     * Get the user associated with the product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        $data['annex'] = $this->imagePath;
        return $data;
    }
}

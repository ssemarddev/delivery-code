<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Base
{

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

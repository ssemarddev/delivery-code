<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Base
{

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }
}

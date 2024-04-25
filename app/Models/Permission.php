<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Base
{

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

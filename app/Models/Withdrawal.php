<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Base
{

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
        return $data;
    }
}

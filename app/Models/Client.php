<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Base
{

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Include relationship to array response
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->city) {
            $data['city'] = $this->city;
        } else {
            $data['city'] = null;
        }
        return $data;
    }
}

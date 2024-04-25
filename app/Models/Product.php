<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Base
{

    public function getImagePathAttribute()
    {
        if ($this->image !== null) {
            return asset("src/$this->image");
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
     * Get the category associated with the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the unit associated with the product.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Gets offers associated with the product.
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * Include relationship to array response
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->offers) {
            $data['offers'] = $this->offers;
        } else {
            $data['offers'] = [];
        }
        if ($this->user) {
            $data['user'] = $this->user;
        } else {
            $data['user'] = null;
        }
        if ($this->category) {
            $data['category'] = $this->category;
        } else {
            $data['category'] = null;
        }
        if ($this->provider) {
            $data['provider'] = $this->provider;
        } else {
            $data['provider'] = null;
        }
        $data['image'] = $this->imagePath;
        return $data;
    }
}

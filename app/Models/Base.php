<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use HasFactory;

    /**
     * Define que todos los atributos pueden ser asignados de forma masiva en la base de datos
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Scope para incluir todos los registros con los ids pasados en el argumento $ids
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param array $ids Ids de los modelos a incluir en el scope
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIds($query, $ids)
    {
        foreach ($ids as $id) {
            $query = $query->orWhere('id', $id);
        }
        return $query;
    }
}

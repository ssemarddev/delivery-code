<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $model = Category::class;

    /**
     * Registra una nueva categoría
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'between:3,60', "unique:categories,name"],
            'status' => ['filled', 'boolean'],
        ]);
        return parent::store($request);
    }

    /**
     * Registra una nueva categoría
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int Id de la categoría a actualizar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'between:3,60', "unique:categories,name,$id"],
            'status' => ['filled', 'boolean']
        ]);
        return parent::update($request, $id);
    }
}

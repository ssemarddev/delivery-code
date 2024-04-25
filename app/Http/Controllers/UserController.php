<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    protected $model = User::class;

    /**
     * Registra un nuevo cliente
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'between:3,100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'username' => ['required', 'between:3,50', 'regex:/^[A-Za-z0-9]+$/', 'unique:users,username'],
            'password' => ['required'],
            'role' => ['required', 'in:Administrador,Vendedor,Bodeguero,Repartidor'],
        ]);
        //Crear la instancia del modelo en la base de datos
        $data = $request->except('permissions');
        $data['password'] = bcrypt($request->password);
        $item = $this->model::create($data);
        foreach ($request->permissions as $permission) {
            Permission::create([
                'user_id' => $item->id,
                'name' => $permission
            ]);
        }
        //Retornar el nuevo modelo
        return response()->json($item);
    }

    /**
     * Actualiza un cliente existente
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int Id de la unidad de medida a actualizar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'between:3,100'],
            'email' => ['required', 'email', "unique:users,email,$id"],
            'username' => ['required', 'between:3,50', 'regex:/^[A-Za-z0-9]+$/', "unique:users,username,$id"],
            'role' => ['required', 'in:Administrador,Vendedor,Bodeguero,Repartidor'],
        ]);
        if ($request->has('password')) {
            throw ValidationException::withMessages([
                'password' => ["No se puede actualizar la contraseña del usuario"],
            ]);
        }
        //Obtener datos de la petición
        $data = $request->except(['_method', 'permissions']);
        //Actualizar el modelo
        $this->model::where('id', $id)->update($data);
        //Retornar el nuevo modelo
        $item = $this->model::find($id);
        Permission::where('user_id', $id)->delete();
        foreach ($request->permissions as $permission) {
            Permission::create([
                'user_id' => $item->id,
                'name' => $permission
            ]);
        }
        return response()->json($item);
    }
}

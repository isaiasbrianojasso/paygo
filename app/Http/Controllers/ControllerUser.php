<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Exception;
class ControllerUser extends Controller
{
    public function add_user(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Crear un nuevo usuario
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($user->password != '') {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        // Obtener los roles seleccionados del formulario
        $roles = $request->input('roles');

        // Asignar los roles al usuario
        $user->roles()->sync($roles);

        // Redireccionar a la página de inicio o a otra vista
        return redirect('/')->with('success', 'Usuario agregado exitosamente');
    }

    public function edit_usuario(User $user)
    {
        // Mostrar el formulario de edición con los datos del usuario
        return view('admin.user', compact('user'));
    }

    public function update_user(Request $request)
    {
        try {
            $user = User::findOrfail($request->id);
            // Actualizar los datos del usuario
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if ($request->input('password') != '') {
                $user->password = bcrypt($request->input('password'));
            }
            $user->save();
            // Redireccionar a la página de inicio o a otra vista
            return redirect('admin/user?token=' . base64_encode($request->id))->with('success', 'Usuario actualizado exitosamente');
        } catch (Exception $e) {
            return redirect('admin/user?token=' . base64_encode($request->id))->with('error', ' Error no se logro actualizar');
        }
    }

    public function destroy(Request $request)
    {
        $user=User::FindOrFail(base64_decode($request->token));
        // Eliminar el usuario
        $user->delete();

        // Redireccionar a la página de inicio o a otra vista
        return redirect('/users/show')->with('success', 'Usuario eliminado exitosamente');
    }
}
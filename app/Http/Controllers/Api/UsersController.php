<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\Pure;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $response;
    public $message;
    public $result;
    public $records;
    public $statusCode;
    public $email;
    public $user;

    public function __construct()
    {
        $this->response = New ResponseController();
        $this->message = 'Consulta exitosa';
        $this->result = true;
        $this->records = [];
        $this->statusCode = 200;
        $this->email = '';
        $this->user = null;
    }
    public function index()
    {
        $users = User::all();
        foreach ($users as $user) {
            $this->records[] = [
                'id'            => $user->id,
                'name'          => $user->name,
                'email'         => $user->email,
                'age'           => $user->age,
                'address'       => $user->address,
                'region'        => $user->region->name,
                'country'       => $user->region->country->name,
                'department'    => $user->department->name,
                'rol'           => $user->rol->name
            ];
        }
        return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate($this->rules());
            if($validate) {
                $validate['password'] = Hash::make($validate['password']);
                User::create($validate);
                $this->statusCode = 201;
                $this->message = 'Usuario creado correctamente';
            }

        } catch (Exception $exception) {
            $this->result = false;
            $this->message = $exception->getMessage();
        } finally {
            return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            $this->result = false;
            $this->message = 'Usuario no encontrado';
        } else {
            $this->records = [
                'id'            => $user->id,
                'name'          => $user->name,
                'email'         => $user->email,
                'age'           => $user->age,
                'address'       => $user->address,
                'region_id'     => $user->region_id,
                'country_id'    => $user->region->country_id,
                'department_id' => $user->department_id,
                'rol_id'        => $user->rol_id
            ];
        }
        return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->user = User::find($id);
            if ($this->user) {
                $this->email = $this->user->email;
                $this->user->email = '';
                $this->user->save();
                $validate = $request->validate($this->rulesUpdate());
                if($validate) {
                    if ($request->password) {
                        $validate['password'] = Hash::make($request->password);
                    }
                    $this->user->update($validate);
                    $this->message = 'Usuario actualizado correctamente';
                }
            } else {
                $this->result = false;
                $this->message = 'Usuario no encontrado';
            }
        } catch (Exception $exception) {
            $this->user->email = $this->email;
            $this->user->save();
            $this->result = false;
            $this->message = $exception->getMessage();
        } finally {
            return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            $this->result = false;
            $this->message = 'Usuario no encontrado';
        } else {
            $user->delete();
            $this->message = 'Usuario eliminado correctamente';
        }
        return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'age' => ['required', 'numeric'],
            'address' => ['required', 'max:255', 'string'],
            'region_id' => ['required', 'exists:regions,id'],
            'rol_id' => ['required', 'exists:rols,id'],
            'department_id' => ['required', 'exists:departments,id'],
        ];
    }

    public function rulesUpdate()
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:users,email', 'email'],
            'age' => ['required', 'numeric'],
            'address' => ['required', 'max:255', 'string'],
            'region_id' => ['required', 'exists:regions,id'],
            'rol_id' => ['required', 'exists:rols,id'],
            'department_id' => ['required', 'exists:departments,id'],
        ];
    }
}

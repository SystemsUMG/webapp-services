<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public $response;
    public $message;
    public $result;
    public $records;
    public $statusCode;

    public function __construct()
    {
        $this->response = New ResponseController();
        $this->message = 'Consulta exitosa';
        $this->result = true;
        $this->records = [];
        $this->statusCode = 200;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $rols = Rol::all();
        foreach ($rols as $rol) {
            $this->records[] = [
                'id'            => $rol->id,
                'name'          => $rol->name,
                'description'   => $rol->description,
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
            $validate = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string'
            ]);
            if($validate) {
                Rol::create($validate);
                $this->statusCode = 201;
                $this->message = 'Rol creado correctamente';
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
        $rol = Rol::find($id);
        if (!$rol) {
            $this->result = false;
            $this->message = 'Rol no encontrado';
        } else {
            $this->records = [
                'id'            => $rol->id,
                'name'          => $rol->name,
                'description'   => $rol->description,
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
            $validate = $request->validate([
                'name' => ['required', 'max:255', 'string'],
                'description' => ['required', 'string']
            ]);
            $rol = Rol::find($id);
            if ($validate && $rol) {
                $rol->update($validate);
                $this->message = 'Rol actualizado correctamente';
            } else {
                $this->result = false;
                $this->message = 'Rol no encontrado';
            }
        } catch (Exception $exception) {
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
        $rol = Rol::find($id);
        if (!$rol) {
            $this->result = false;
            $this->message = 'Rol no encontrado';
        } else {
            $user = User::where('rol_id', $rol->id)->first();
            if (!$user) {
                $rol->delete();
                $this->message = 'Rol eliminado correctamente';
            } else {
                $this->result = false;
                $this->message = 'No eliminado, otros registros dependen de esta rol';
            }
        }
        return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }
}

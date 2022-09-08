<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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
        $departments = Department::all();
        foreach ($departments as $department) {
            $this->records[] = [
                'id'            => $department->id,
                'name'          => $department->name,
                'description'   => $department->description,
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
                Department::create($validate);
                $this->statusCode = 201;
                $this->message = 'Departamento creado correctamente';
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
        $department = Department::find($id);
        if (!$department) {
            $this->result = false;
            $this->message = 'Departamento no encontrado';
        } else {
            $this->records = [
                'id'            => $department->id,
                'name'          => $department->name,
                'description'   => $department->description,
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
            $department = Department::find($id);
            if ($validate && $department) {
                $department->update($validate);
                $this->message = 'Departamento actualizado correctamente';
            } else {
                $this->result = false;
                $this->message = 'Departamento no encontrado';
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
        $department = Department::find($id);
        if (!$department) {
            $this->result = false;
            $this->message = 'Departamento no encontrado';
        } else {
            $user = User::where('department_id', $department->id)->first();
            if (!$user) {
                $department->delete();
                $this->message = 'Departamento eliminado correctamente';
            } else {
                $this->result = false;
                $this->message = 'No eliminado, otros registros dependen de esta departamento';
            }
        }
        return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }
}

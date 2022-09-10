<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RegionController extends Controller
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
        $regions = Region::all();
        foreach ($regions as $region) {
            $this->records[] = [
                'id'        => $region->id,
                'name'      => $region->name,
                'country'    => $region->country->name
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
                'name' => ['required', 'max:255', 'string'],
                'country_id' => ['required', 'exists:countries,id']
            ]);
            if($validate) {
                Region::create($validate);
                $this->statusCode = 201;
                $this->message = 'Región creada correctamente';
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
        $region = Region::find($id);
        if (!$region) {
            $this->result = false;
            $this->message = 'Región no encontrada';
        } else {
            $this->records = [
                'id'         => $region->id,
                'name'       => $region->name,
                'country_id' => $region->country_id,
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
                'country_id' => ['required', 'exists:countries,id']
            ]);
            $region = Region::find($id);
            if ($validate && $region) {
                $region->update($validate);
                $this->message = 'Región actualizada correctamente';
            } else {
                $this->result = false;
                $this->message = 'Región no encontrada';
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
        $region = Region::find($id);
        if (!$region) {
            $this->result = false;
            $this->message = 'Región no encontrada';
        } else {
            $user = User::where('region_id', $region->id)->first();
            if (!$user) {
                $region->delete();
                $this->message = 'Región eliminada correctamente';
            } else {
                $this->result = false;
                $this->message = 'No eliminado, otros registros dependen de esta región';
            }
        }
        return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }
}

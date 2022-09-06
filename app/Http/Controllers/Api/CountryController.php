<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Region;
use Exception;
use Illuminate\Http\Request;

class CountryController extends Controller
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
        $countries = Country::all();
        foreach ($countries as $country) {
            $this->records[] = [
                'id'        => $country->id,
                'name'      => $country->name,
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
            ]);
            if($validate) {
                Country::create($validate);
                $this->statusCode = 201;
                $this->message = 'País creado correctamente';
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
        $country = Country::find($id);
        if (!$country) {
            $this->result = false;
            $this->message = 'País no encontrado';
        } else {
            $this->records = $country;
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
            ]);
            $country = Country::find($id);
            if ($validate && $country) {
                $country->update($validate);
                $this->message = 'País actualizado correctamente';
            } else {
                $this->result = false;
                $this->message = 'País no encontrado';
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
        $country = Country::find($id);
        if (!$country) {
            $this->result = false;
            $this->message = 'País no encontrado';
        } else {
            $region = Region::where('country_id', $country->id)->first();
            if (!$region) {
                $country->delete();
                $this->message = 'País eliminado correctamente';
            } else {
                $this->result = false;
                $this->message = 'No eliminado, otros registros dependen de este país';
            }

        }
        return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }
}

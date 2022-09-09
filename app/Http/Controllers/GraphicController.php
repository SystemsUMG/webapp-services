<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ResponseController;
use App\Models\Country;
use App\Models\Department;
use App\Models\Region;
use App\Models\Rol;
use App\Models\User;

class GraphicController extends Controller
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
    public function graphic() {
        $countries = Country::all();
        $array_countries = [];
        $array_users = [];
        foreach ($countries as $country) {
            $array_countries[] = $country->name;
            $array_users[] = User::whereRelation('region', 'country_id', $country->id)->count();
        }
        $this->records['countries'] = $array_countries;
        $this->records['users_real'] = $array_users;
        $this->records['totals'] = [
            'total_users' => User::count(),
            'total_countries' => Country::count(),
            'total_regions' => Region::count(),
            'total_departments' => Department::count(),
            'total_rols' => Rol::count(),
        ];

        return $this->response->jsonResponse($this->records, $this->result, $this->message, $this->statusCode);
    }
}

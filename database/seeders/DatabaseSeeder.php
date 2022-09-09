<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Country;
use App\Models\Department;
use App\Models\Region;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Country::factory(6)->create();
        Region::factory(8)->create();
        Rol::factory(3)->create();
        Department::factory(8)->create();
        User::factory(20)->create();

        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'age' => 21,
            'password' => Hash::make('admin'),
            'address' => 'Chimaltenango, Guatemala',
            'region_id' => 1,
            'rol_id' => 1,
            'department_id' => 2,
         ]);
    }
}

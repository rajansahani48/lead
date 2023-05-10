<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            \DB::table('users')->insert([
                'name' =>'Rajan',
                'email' =>'rajan@gmail.com',
                'password' =>Hash::make('123'),
                'phone' =>'9725085433',
                'country_code' =>'3960001',
                'address'=>'Valsad',
                'role'=>'admin',
            ]);
    }
}

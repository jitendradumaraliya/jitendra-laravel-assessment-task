<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'first_name' => 'Master',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);
    }
}

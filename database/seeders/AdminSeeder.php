<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = \App\Models\Admin::factory()->create([
            'name' => 'Admin',
            'email' => 'canvandiet@gmail.com',
            'password' => Hash::make('canvandiet@gmail.com'),
            'status' => rand(0, 1),
        ]);
        $admin->assignRole([2]);

        $admin = \App\Models\Admin::factory()->create([
            'name' => 'Nguyễn Tú',
            'email' => 'tu@gmail.com',
            'password' => Hash::make('tu@gmail.com'),
            'status' => 1,
        ]);
        $admin->assignRole([2]);

        $admin = \App\Models\Admin::factory()->create([
            'name' => 'Tuấn anh',
            'email' => 'vudaotuananh@gmail.com',
            'password' => Hash::make('vudaotuananh@gmail.com'),
            'status' => 1,
        ]);
        $admin->assignRole([2]);
    }
}
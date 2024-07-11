<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attributes')->insert([
            'name' => 'Color',
            'value' =>  '#FF66FF',
            'status' => 1,
        ]);
        DB::table('attributes')->insert([
            'name' => 'Color',
            'value' =>  '#0000CC',
            'status' => 1,
        ]);
        DB::table('attributes')->insert([
            'name' => 'Color',
            'value' =>  '#CCCC00',
            'status' => 1,
        ]);
        DB::table('attributes')->insert([
            'name' => 'Color',
            'value' =>  '#111111',
            'status' => 1,
        ]);
        DB::table('attributes')->insert([
            'name' => 'Color',
            'value' =>  '#006699',
            'status' => 1,
        ]);
        DB::table('attributes')->insert([
            'name' => 'Color',
            'value' =>  '#006600',
            'status' => 1,
        ]);
        DB::table('attributes')->insert([
            'name' => 'Ram',
            'value' =>  '1T',
            'status' => 2,
        ]);
        DB::table('attributes')->insert([
            'name' => 'Ram',
            'value' =>  '128GB',
            'status' => 2,
        ]);
        DB::table('attributes')->insert([
            'name' => 'Ram',
            'value' =>  '512GB',
            'status' => 2,
        ]);
        DB::table('attributes')->insert([
            'name' => 'Ram',
            'value' =>  '256GB',
            'status' => 2,
        ]);
        DB::table('attributes')->insert([
            'name' => 'Ram',
            'value' =>  '8T',
            'status' => 2,
        ]);
        DB::table('attributes')->insert([
            'name' => 'Ram',
            'value' =>  '16T',
            'status' => 2,
        ]);
    }
}

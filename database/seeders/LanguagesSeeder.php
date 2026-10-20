<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->truncate();
        DB::table('languages')->insert(array(
            array(
                'name' => 'Türkçee',
                'code' => 'tr',
                'sort_order' => 1,
                'status' => 1,
                'created_by' => 1,
            ),
            array(
                'name' => 'English',
                'code' => 'en',
                'sort_order' => 2,
                'status' => 1,
                'created_by' => 1,
            ),
            array(
                'name' => 'Deutsch',
                'code' => 'de',
                'sort_order' => 3,
                'status' => 1,
                'created_by' => 1,
            )
        ));
    }
}

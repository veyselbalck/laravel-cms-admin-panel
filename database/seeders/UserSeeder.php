<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        DB::table('users')->truncate();
        $users = array(
            array(
                'id' => '1',
                'user_group_id' => '1',
                'password' => Hash::make('52761282.'),
                'name' => 'Mehmet KIYAK',
                'email' => 'mkiyak511@gmail.com',
                'ip' => request()->ip(),
                'status' => 1,
                'role' => "super",
                'created_by' => 1,
                'created_at' => now(),
            ),
        );

        foreach ($users as $item) {
            DB::table('users')->insert($item);
        }
    }
}

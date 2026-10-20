<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_group')->truncate();

        $permissions_all = [
            'users'         => ["index" => 1, "create" => "1", "edit" => "1", "destroy" => "1"],
            'settings'      => ["index" => 1, "create" => "1", "edit" => "1", "destroy" => "1"],
            'languages'     => ["index" => 1, "create" => "1", "edit" => "1", "destroy" => "1"],
            'contents'      => ["index" => 1, "create" => "1", "edit" => "1", "destroy" => "1"],
            'modules'       => ["index" => 1, "create" => "1", "edit" => "1", "destroy" => "1"],
            'city'          => ["index" => 1, "create" => "1", "edit" => "1", "destroy" => "1"],
            'country'       => ["index" => 1, "create" => "1", "edit" => "1", "destroy" => "1"],
            'roles'         => ["index" => 1, "create" => "1", "edit" => "1", "destroy" => "1"],
        ];

        $users = array(
            array(
                'name' => 'Kurucu Yönetici',
                'status' => 1,
                'permission' => json_encode($permissions_all),
                'created_by' => 1,
                'created_at' => now(),
            )
        );

        foreach ($users as $item) {
            DB::table('user_group')->insert($item);
        }
    }
}

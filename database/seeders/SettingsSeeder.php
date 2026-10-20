<?php

namespace Database\Seeders;

use App\Models\Panel\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();

        Settings::insert([
            'code' => 'config',
            'value' => json_encode([
                'app' => [
                    'name' => 'CMS Web Sitesi',
                    'email' => 'info@mehmetkiyak.com.tr',
                    'telephone' => '0530 000 00 00',
                    'fax' => '',
                    'timezone' => 'Europe/Istanbul',
                    'country_id' => '215',
                    'city_id' => '3354',
                    'locale' => 'tr',
                    'debug' => '1',
                    'compression' => '9',
                ],
                'frontend' => [
                    'socials' => [
                        'facebook' => array(
                            'href'          => 'https://www.facebook.com',
                            'icon'          => '',
                            'status'        => 1
                        ),
                        'twitter' => array(
                            'href'          => 'https://twitter.com',
                            'icon'          => '',
                            'status'        => 1
                        ),
                        'instagram' => array(
                            'href'          => 'https://www.instagram.com/',
                            'icon'          => '',
                            'status'        => 1
                        ),
                        'youtube' => array(
                            'href'          => 'https://www.youtube.com',
                            'icon'          => '',
                            'status'        => 1
                        ),
                        'clubhouse' => array(
                            'href'          => 'https://www.clubhouse.com',
                            'icon'          => '',
                            'status'        => 1
                        ),
                        'behance' => array(
                            'href'          => 'https://www.behance.com',
                            'icon'          => '',
                            'status'        => 1
                        ),
                        'pinterest' => array(
                            'href'          => 'https://www.pinterest.com',
                            'icon'          => '',
                            'status'        => 1
                        ),
                        'googleplus' => array(
                            'href'          => 'https://www.googleplus.com',
                            'icon'          => '',
                            'status'        => 1
                        ),
                        'linkedin' => array(
                            'href'          => 'https://tr.linkedin.com/company',
                            'icon'          => '',
                            'status'        => 1
                        ),
                    ]
                ]
            ]),
            'created_by' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}

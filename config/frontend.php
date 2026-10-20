<?php

return [

    'socials' => [
        'facebook'      => array('href' => '', 'icon' =>'', 'status' => 0),
        'twitter'       => array('href' => '', 'icon' =>'', 'status' => 0),
        'instagram'     => array('href' => '', 'icon' =>'', 'status' => 0),
        'youtube'       => array('href' => '', 'icon' =>'', 'status' => 0),
        'clubhouse'     => array('href' => '', 'icon' =>'', 'status' => 0),
        'linkedin'      => array('href' => '', 'icon' =>'', 'status' => 0),
        'behance'       => array('href' => '', 'icon' =>'', 'status' => 0),
        'pinterest'     => array('href' => '', 'icon' =>'', 'status' => 0),
        'googleplus'    => array('href' => '', 'icon' =>'', 'status' => 0),
        'tiktok'        => array('href' => '', 'icon' =>'', 'status' => 0),
        'whatsapp'      => array('href' => '', 'icon' =>'', 'status' => 0),
    ],

    'captcha' => [
        'status' => false,
        'site_key' => env('RECAPTCHAV3_SITEKEY', ''),
        'secret' => env('RECAPTCHAV3_SECRET', ''),
    ]
];

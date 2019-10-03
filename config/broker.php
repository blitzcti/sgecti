<?php

return [
    'useSSO' => env('USE_SSO', false),

    /*
     |--------------------------------------------------------------------------
     | Laravel SSO Settings
     |--------------------------------------------------------------------------
     |
     | Set type of this web page. Possible options are: 'server' and 'broker'.
     |
     | You must specify either 'server' or 'broker'.
     |
     */

    'url' => env('SSO_SERVER_URL', '127.0.0.1'),
    'name' => env('SSO_BROKER_NAME', 'sge'),
    'secret' => env('SSO_BROKER_SECRET', null),
];

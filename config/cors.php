<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'api/v1/*', '*'],

    'allowed_methods' => ['POST', 'GET', 'DELETE', 'PUT', '*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['X-Custom-Header', 'Upgrade-Insecure-Requests', '*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];

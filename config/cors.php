<?php

return [

    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    // Replace with the actual origin of your frontend app
    'allowed_origins' => ['http://localhost:3000', 'https://your-frontend-domain.com'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Required if you're sending Authorization headers or cookies
    'supports_credentials' => true,

];

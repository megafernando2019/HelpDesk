<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configuración de propiedades para los envios de correos
    |--------------------------------------------------------------------------
    |
    |
    */

    // URL del endpoint
    'endpoint' => env('MTMAIL_ENDPOINT', 'https://mtmail.megatravel.online/api/send'),

    // Llaves que la API requiere
    'fields' => [
        'to',
        'subject',
        'body',
        'tags',
        'user',
        'attach',
        'cc'
    ],

];

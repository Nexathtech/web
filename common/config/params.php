<?php

/**
 * Declares custom config params for application.
 */

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,

    // Security params
    'security' => [
        // JSON web tokens
        'jwt' => [
            'secret' => getenv('KODI_SEC_JWT_SECRET'),
            'expiration' => 60 * 60 * 24, // 24 hours
        ],

        // Custom tokens
        'token' => [
            'access' => [
                'expiration' => 60 * 60 * 12 // 12 hours. Token expiration period. Note, it was increased from 1 hour because on the client side there may be different time
            ],
            'refresh' => [
                'expiration' => 60 * 60 * 24 * 10 // 10 days. It applies only to refresh tokens
            ],
        ]
    ],
];

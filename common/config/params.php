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
    ],
];

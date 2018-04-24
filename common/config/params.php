<?php

/**
 * Declares custom config params for application.
 */

return [
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
                'expiration' => 60 * 60 * 1 // 1 hour. Token expiration period
            ],
            'refresh' => [
                'expiration' => 60 * 60 * 24 * 10 // 10 days. It applies only to refresh tokens
            ],
        ]
    ],

    'services' => [
        'mailChimp' => [
            'listId' => 'af6368bc4b',
        ],
    ],

    // Upload files params
    'files' => [
        'maxFiles' => 0, // 0 for unlimited (note, it might be lower in server configuration (php.ini))
        'maxSize' => 1024 * 1024 * 10, // 10 MB (note, it might be lower in server configuration (php.ini))
        'images' => [
            'maxWidth' => 1000, // px
            'maxHeight' => 1000, // px
        ],
    ],

    // Emails
    'emails' => [
        'noreply' => 'no-reply@meetkodi.com'
    ]
];

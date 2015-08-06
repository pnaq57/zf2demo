<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'storageSettings' => array(
        'st01' => array(
            'VA_FILES' => 'VA_FILES',
            'VA_INBOX' => 'VA_INBOX',
            'path' => '/var/storage/'
        ),
        'st02' => array(
            'VA_FILES' => 'VA_FILES',
            'VA_INBOX' => 'VA_INBOX',
            'path' => '/var/storage/'
        ),
        'st03' => array(
            'VA_FILES' => 'VA_FILES',
            'VA_INBOX' => 'VA_INBOX',
            'path' => '/var/storage/'
        ),
        'st04' => array(
            'VA_FILES' => 'VA_FILES',
            'VA_INBOX' => 'VA_INBOX',
            'path' => '/var/storage/'
        ),
    )
);

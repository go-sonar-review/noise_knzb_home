<?php

return [
    'enabled'        => getenv('SENTRY_ENABLED'),
    'anonymous'      => false, // Determines to log user info or not
    'clientDsn'      => getenv('SENTRY_DSN'), // Set as string or use environment variable.
    'excludedCodes'  => ['400', '404', '429'],
    'release'        => getenv('SENTRY_RELEASE') ?: null, // Release number/name used by sentry.
    'reportJsErrors' => false,
    'sampleRate'     => 1.0,
];

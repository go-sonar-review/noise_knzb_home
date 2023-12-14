<?php

/**
 * Yii Application Config
 *
 * Edit this file at your own risk!
 *
 * The array returned by this file will get merged with
 * vendor/craftcms/cms/src/config/app.php and app.[web|console].php, when
 * Craft's bootstrap script is defining the configuration for the entire
 * application.
 *
 * You can define custom modules and system components, and even override the
 * built-in system components.
 *
 * If you want to modify the application config for *only* web requests or
 * *only* console requests, create an app.web.php or app.console.php file in
 * your config/ folder, alongside this one.
 */

$components = [
    'queue' => [
        'ttr' => 1200,
    ]
];
    
$components['session'] = function () {
    // Get the default component config
    $config = craft\helpers\App::sessionConfig();

    // Override the class to use DB session class
    $config['class'] = yii\web\DbSession::class;

    // Set the session table name
    $config['sessionTable'] = craft\db\Table::PHPSESSIONS;

    // Instantiate and return it
    return Craft::createObject($config);
};

if (filter_var(getenv('REDIS_ENABLED'), FILTER_VALIDATE_BOOLEAN)) {
    // Determine connection url and parse it
    $redisUrl = getenv('REDIS_TLS_URL') ? getenv('REDIS_TLS_URL') : getenv('REDIS_URL');
    $parsedRedisUrl = parse_url($redisUrl);

    $components['redis'] = [
        'class' => yii\redis\Connection::class,
        'hostname' => $parsedRedisUrl['host'],
        'port' => $parsedRedisUrl['port'],
        'password' => $parsedRedisUrl['pass'] !== '' ? $parsedRedisUrl['pass'] : null,
        'useSSL' => $parsedRedisUrl['scheme'] === 'rediss' ? true : false,
        'contextOptions' => [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ],
    ];

    $components['cache'] = [
        'class' => yii\redis\Cache::class,
        'defaultDuration' => 86400,
        'keyPrefix' => getenv('REDIS_KEY_PREFIX'),
    ];

    $components['mutex'] = [
        'mutex' => 'yii\redis\Mutex',
    ];
}

return [
    'components' => $components,
    'modules' => [
        'np' => \modules\np\Module::class,
    ],
    'bootstrap' => ['np'],
];

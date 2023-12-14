<?php

/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

return [
    // Global settings
    '*' => [
        // Default Week Start Day (0 = Sunday, 1 = Monday...)
        'defaultWeekStartDay' => 1,

        // Store tags locally and purge Urls
        // In case the cache driver does not support tag purging
        'useLocalTags'  => false,

        // Whether generated URLs should omit "index.php"
        'omitScriptNameInUrls' => true,

        // Control Panel trigger word
        'cpTrigger' => 'admin',

        // The secure key Craft will use for hashing and encrypting data
        'securityKey' => getenv('SECURITY_KEY'),

        // Whether to save the project config out to config/project.yaml
        // (see https://docs.craftcms.com/v3/project-config.html)
        'useProjectConfigFile' => true,

        'enableGql' => false,

        // 'disabledPlugins' => ['webhooks'],

        'backupOnUpdate' => false,

        'enableCsrfProtection' => false,

        'sendPoweredByHeader' => false,

        'aliases' => [
            '@webroot' => dirname(__DIR__) . '/web',
        ],

        'runQueueAutomatically' => filter_var(getenv('RUN_QUEUE_AUTOMATICALLY'), FILTER_VALIDATE_BOOLEAN), // Use a worker process to handle items in the queue

        'limitAutoSlugsToAscii' => true, // Whether non-ASCII characters in auto-generated slugs should be converted to ASCII (i.e. ñ → n)

        'convertFilenamesToAscii' => true, // Whether uploaded filenames with non-ASCII characters should be converted to ASCII (i.e. ñ → n)

        'maxRevisions' => 10, // The maximum number of revisions that should be stored for each element. Set to 0 if you want to store an unlimited number of revisions

        'addTrailingSlashesToUrls' => false, // Whether auto-generated URLs should have trailing slashes

        'brokenImagePath' => 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==', // Transparent 1x1 GIF
        
        'resourceBasePath' => dirname(__DIR__) . '/web/cpresources',

        'pageTrigger' => '?page',

        'extraAllowedFileExtensions' => 'mdb, lxf, xml',

        'generateTransformsBeforePageLoad' => true,
    ],

    // Dev environment settings
    'dev' => [
        // Dev Mode (see https://craftcms.com/guides/what-dev-mode-does)
        'devMode' => true,
        'cacheElementQueries' => false,
        'enableSchemaCache' => false,
        'enableTemplateCaching' => false,
    ],

    // Staging environment settings
    'staging' => [
        'allowAdminChanges' => false,
        // for better perfomance
        'cacheElementQueries' => false,
        'enableSchemaCache' => true,
        'enableTemplateCaching' => filter_var(getenv('REDIS_ENABLED'), FILTER_VALIDATE_BOOLEAN),
        // for better security
        'preventUserEnumeration' => true,
        'enableGraphqlIntrospection' => false,
    ],

    // Production environment settings
    'production' => [
        'allowAdminChanges' => false,
        // for better perfomance
        'cacheElementQueries' => false,
        'enableSchemaCache' => true,
        'enableTemplateCaching' => filter_var(getenv('REDIS_ENABLED'), FILTER_VALIDATE_BOOLEAN),
        // for better security
        'preventUserEnumeration' => true,
        'enableGraphqlIntrospection' => false,
    ],
];

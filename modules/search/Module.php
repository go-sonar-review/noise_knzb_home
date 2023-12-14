<?php

namespace modules\search;

use craft\helpers\App;

use modules\search\transformers\channels\AgendaTransformer;
use modules\search\transformers\DefaultTransformer;

/**
 * This class serves as the configuration used by the Scout Algolia plugin.
 *
 * For the mapping overview, see the sharepoint link.
 *
 * @see /config/scout.php -> indices
 * @link https://kpn1310613.sharepoint.com/:x:/s/production/EWtJPFihgm1HoF4Do3MHDfoBrEMKRGtktciUvctKsp5BlA?e=JP4aYg
 */
class Module
{
    public const SEARCH_DATE_TIME_FORMAT = 'd LLLL y, H:mm';

    public static function getConfig()
    {
        $indices = [];
        $indexName = App::env('ENVIRONMENT');

        foreach (self::config() as $section) {

            $indices[] = \rias\scout\ScoutIndex::create($section['handle'] ."-". $indexName)
                ->elementType(\craft\elements\Entry::class)
                ->criteria(function (\craft\elements\db\EntryQuery $query) use ($section) {
                    return $query
                        ->section($section['handle'])
                        ->status('live');
                })
                ->transformer($section['transformer']);
        }

        return $indices;
    }

    /**
     * Return the various Scout configuration settings.
     *
     * Each Craft entry, referred to by it's Craft handle, can by assigned a Transformer which will
     * be used by Scout to transform the data for Algolia consumption. Note that some entries use the
     * same transformer. This is because they are either identical (e.g. the singles pages) or share one
     * or more possible entry types.
     *
     * @todo Implement custom indexSettings
     *
     * @return array
     */
    private static function config(): array
    {
        return [
            [
                'handle' => 'news',
                'transformer' => DefaultTransformer::class
            ],
            [
                'handle' => 'agenda',
                'transformer' => AgendaTransformer::class
            ],
            [
                'handle' => 'blogs',
                'transformer' => DefaultTransformer::class
            ],
            [
                'handle' => 'knowledgeArticles',
                'transformer' => DefaultTransformer::class
            ],
            [
                'handle' => 'showcases',
                'transformer' => DefaultTransformer::class
            ],
            [
                'handle' => 'vacancies',
                'transformer' => DefaultTransformer::class
            ],
            [
                'handle' => 'businesses',
                'transformer' => DefaultTransformer::class
            ],
            [
                'handle' => 'homepage',
                'transformer' => DefaultTransformer::class
            ],
            [
                'handle' => 'pages',
                'transformer' => DefaultTransformer::class
            ],
        ];
    }
}

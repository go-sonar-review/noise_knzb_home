<?php

namespace modules\search\parsers;

class FeaturedImageParser implements FieldParser
{
    public static function parse($featuredImage): array
    {
        $featuredImage = $featuredImage->one();

        if ($featuredImage) {
            return [
                "featuredImage" => [
                    'url' => $featuredImage->getUrl(),
                    'srcset' => $featuredImage->getSrcset(['375w', '750w', '1200w'], [ "format" => "jpeg" ]),
                    'srcsetWebp' => $featuredImage->getSrcset(['375w', '750w', '1200w'], [ "format" => "webp" ]),
                    'title' => $featuredImage->title,
                    'alt' => $featuredImage->title
                ]
            ];
        }

        return [];
    }
}

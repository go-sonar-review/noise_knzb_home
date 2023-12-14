<?php

namespace modules\search\parsers;

class LinkParser implements FieldParser
{
    public static function parse($link): array
    {
        if ($link) {
            return [
                "link" => [
                    'url' => $link->url,
                    'text' => $link->text,
                    'target' => isset($link->target) ? $link->target : '_self'
                ]
            ];
        }

        return [];
    }
}

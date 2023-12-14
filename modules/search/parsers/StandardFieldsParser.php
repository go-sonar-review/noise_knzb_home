<?php

namespace modules\search\parsers;

class StandardFieldsParser implements FieldParser
{
    public static function parse($entry): array
    {
        return [
            'url' => $entry->url,
            'title' => $entry->title,
            'featured' => $entry->featured,
            'summary' => $entry->summary,
            'type' => $entry->type->handle,
            'section' => [
                "id" => $entry->section->id,
                "name" => $entry->section->name,
                "handle" => $entry->section->handle
            ],
            'type' => [
                "id" => $entry->type->id,
                "name" => $entry->type->name,
                "handle" => $entry->type->handle
            ],
            'datePublished' => $entry->site->locale->formatter->asDate($entry->postDate, "long"),
            'datePublishedTimeStamp' => $entry->postDate->getTimestamp(),
            'categories' => $entry->categories ? $entry->categories->select('title')->column() : [],
            'cardTitle' => $entry->cardTitle ?? $entry->title,
            'cardSummary' => $entry->cardSummary ?? $entry->summary
        ];
    }
}

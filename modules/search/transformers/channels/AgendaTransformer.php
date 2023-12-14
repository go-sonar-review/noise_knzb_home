<?php

namespace modules\search\transformers\channels;

use modules\search\Module;
use modules\search\transformers\Transformer;
use modules\search\parsers\FeaturedImageParser;
use modules\search\parsers\BlocksParser;
use modules\search\parsers\StandardFieldsParser;

class AgendaTransformer implements Transformer
{
    public function __invoke($entry): array
    {
        $data = [
            'startDate' => $entry->startDate,
            'endDate' => $entry->endDate,
            'startDateFormatted' => $entry->site->locale->formatter->asDateTime($entry->startDate, Module::SEARCH_DATE_TIME_FORMAT),
            'endDateFormatted' => $entry->site->locale->formatter->asDateTime($entry->endDate, Module::SEARCH_DATE_TIME_FORMAT),
        ];

        $data = array_merge($data, StandardFieldsParser::parse($entry));
        $data = array_merge($data, FeaturedImageParser::parse($entry->featuredImage));
        $data = array_merge($data, BlocksParser::parse($entry->blocks));

        return $data;
    }
}

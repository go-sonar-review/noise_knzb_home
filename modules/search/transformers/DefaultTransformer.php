<?php

namespace modules\search\transformers;

use modules\search\transformers\Transformer;
use modules\search\parsers\FeaturedImageParser;
use modules\search\parsers\BlocksParser;
use modules\search\parsers\StandardFieldsParser;

class DefaultTransformer implements Transformer
{
    public function __invoke($entry): array
    {
        $data = [];
        $data = array_merge($data, StandardFieldsParser::parse($entry));
        $data = array_merge($data, FeaturedImageParser::parse($entry->featuredImage));
        $data = array_merge($data, BlocksParser::parse($entry->blocks));

        return $data;
    }
}

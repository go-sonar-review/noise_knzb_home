<?php

namespace modules\search\parsers;

interface FieldParser
{
    public static function parse($fieldData): array;
}

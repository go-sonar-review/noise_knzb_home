<?php

namespace modules\search\transformers;

interface Transformer
{
    public function __invoke($entry): array;
}

<?php

namespace modules\np\services;

use modules\np\services\Api;

class TemplateService
{
    public function get($path)
    {
        return Api::get($path);
    }

    public function post($path, $data = null)
    {
        return Api::post($path, $data);
    }
}

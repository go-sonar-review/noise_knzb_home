<?php

namespace modules\np\services;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class TwigExtension extends AbstractExtension implements GlobalsInterface
{
    public function getGlobals()
    {
        return [
            'np' => (object) [
                'helpers'   => new HelperService(),
                'template'  => new TemplateService()
            ]
        ];
    }
}

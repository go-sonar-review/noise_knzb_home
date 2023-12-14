<?php

namespace modules\np;

use Craft;
use modules\np\services\TwigExtension;

class Module extends \yii\base\Module
{
    public function __construct()
    {
        Craft::setAlias('@modules', __DIR__);
        parent::init();

        if (Craft::$app->request->getIsSiteRequest()) {
            Craft::$app->view->registerTwigExtension(new TwigExtension());
        }

        // Event::on(
        //     Cp::class,
        //     Cp::EVENT_REGISTER_CP_NAV_ITEMS,
        //     function (RegisterCpNavItemsEvent $event) {
        //         $event->navItems[] = [
        //             'url' => 'section-url',
        //             'label' => 'Section Label',
        //             // 'icon' => '@mynamespace/path/to/icon.svg',
        //         ];
        //     }
        // );
    }
}

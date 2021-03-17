<?php

namespace AndersBjorkland\MatomoAnalyticsExtension;

use Bolt\Extension\BaseExtension;
use Symfony\Component\Routing\Route;


class Extension extends BaseExtension
{

    public function getName(): string
    {
        return "Matomo Analytics";
    }

    public function initialize(): void
    {
        $configs = $this->getConfig();

        $this->addWidget(new MatomoAnalyticsWidget($configs));
        $this->addTwigNamespace('matomo-analytics-extension');
        $this->addListener('kernel.response', [new EventListener(), 'handleEvent']);
    }

    public function getRoutes(): array
    {
        return [
            'matomo_chart' => new Route(
                '/extensions/matomo-analytics/chart.jpg',
                ['_controller' => 'AndersBjorkland\MatomoAnalyticsExtension\Controller\ChartsController::index']
            ),
            'matomo_debug' => new Route(
                '/extensions/matomo-analytics/debug',
                ['_controller' => 'AndersBjorkland\MatomoAnalyticsExtension\Controller\ChartsController::debug']
            ),
        ];
    }

}
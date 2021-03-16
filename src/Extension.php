<?php

namespace AndersBjorkland\MatomoAnalyticsExtension;

use Bolt\Extension\BaseExtension;
use Symfony\Component\Dotenv\Dotenv;


class Extension extends BaseExtension
{
    public function getName(): string
    {
        return "Matomo Analytics";
    }

    public function initialize(): void
    {
        $dotenv = new Dotenv();
        $dotenv->loadEnv(__DIR__.'/.env');
        $key = $_ENV['MATOMO_API_KEY'];
        $this->getConfig();
        dump($this->getConfig());
        dump($key);
        //dump($this->config->get('general/matomo'));
    }
}
<?php


namespace AndersBjorkland\MatomoAnalyticsExtension\Controller;

use AndersBjorkland\MatomoAnalyticsExtension\ExtensionConfig;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ChartsController extends AbstractController
{

    private $config;

    public function __construct(ExtensionConfig $config)
    {
        $this->config = $config;
    }


    public function index(): Response
    {
        $configs = $this->config->getConfig();
        if ($configs['authorized_only']) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        $domain = $configs["matomo_domain"];
        $apiToken = $configs["matomo_api_token"];

        $target = "$domain/index.php?module=API&method=ImageGraph.get&idSite=1"
            . "&apiModule=VisitsSummary&apiAction=get&token_auth=$apiToken&graphType=evolution"
            . "&period=day&date=previous30&width=500&height=250";


        $contents = file_get_contents($target);

        return new Response($contents, 200, ['Content-Type'=>'image/jpeg']);
    }

    public function debug(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return new Response(json_encode($this->config->getConfig()), 200, ['Content-Type' => 'application/json']);
    }

}
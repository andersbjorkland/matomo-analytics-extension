<?php


namespace AndersBjorkland\MatomoAnalyticsExtension;


use Bolt\Widget\BaseWidget;
use Bolt\Widget\CacheAwareInterface;
use Bolt\Widget\CacheTrait;
use Bolt\Widget\Injector\AdditionalTarget;
use Bolt\Widget\Injector\RequestZone;
use Bolt\Widget\StopwatchAwareInterface;
use Bolt\Widget\StopwatchTrait;
use Bolt\Widget\TwigAwareInterface;
use Tightenco\Collect\Support\Collection;

class MatomoAnalyticsWidget extends BaseWidget implements TwigAwareInterface, StopwatchAwareInterface, CacheAwareInterface
{
    use CacheTrait;
    use StopwatchTrait;

    protected $name;
    protected $target;
    protected $priority;
    protected $template;
    protected $zone;
    protected $cacheDuration;
    protected $statistics;
    protected $domain;

    /**
     * MatomoAnalyticsWidget constructor.
     */
    public function __construct(Collection $configs)
    {
        $this->name = $configs["extension_name"];
        $this->target = AdditionalTarget::WIDGET_BACK_DASHBOARD_ASIDE_TOP;
        $this->priority = 100;
        $this->template = '@matomo-analytics-extension/widget.html.twig';
        $this->zone = RequestZone::BACKEND;
        $this->cacheDuration = -1800;


        $this->domain = $configs["matomo_domain"];
        $token_auth = $configs["matomo_api_token"];
        $method = $configs["matomo_method"];

        // we call the REST API and request the 100 first keywords for the last month for the idsite=62
        $url = $this->domain;
        $url .= "?module=API&method=$method";
        $url .= "&idSite=all&period=month&date=today";
        $url .= "&format=JSON&filter_limit=10";
        $url .= "&token_auth=$token_auth";

        $fetched = file_get_contents($url);
        $content = json_decode($fetched,true);



        if (!$content) {
            $this->statistics = null;
        } else {
            /*  Returns the result for first site when using API-call with idSite=all. */
            $siteone = reset($content);
            $this->statistics = $siteone;
        }


    }

    /**
     * @return mixed
     */
    public function getStatistics()
    {
        return $this->statistics;
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }


}
<?php


namespace AndersBjorkland\MatomoAnalyticsExtension;


use Bolt\Configuration\Config;
use Bolt\Extension\ExtensionRegistry;

class ExtensionConfig
{
    /** @var array */
    private $config = null;

    /**
     * @var ExtensionRegistry
     */
    private $registry;

    /**
     * @var Config
     */
    private $boltConfig;

    public function __construct(
        ExtensionRegistry $registry,
        Config $boltConfig
    ) {
        $this->registry = $registry;
        $this->boltConfig = $boltConfig;
    }

    public function getConfig(): array
    {
        if ($this->config) {
            return $this->config;
        }

        $extension = $this->registry->getExtension(Extension::class);

        $configItems = array_replace_recursive((array)$extension->getConfig());
        $configs = [];
        foreach ($configItems as $item) {
            foreach ($item as $key => $value) {
                $configs[$key] = $value;
            }
        }

        $this->config = $configs;

        return $configs;
    }
}
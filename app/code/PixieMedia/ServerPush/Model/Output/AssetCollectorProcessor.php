<?php

declare(strict_types=1);

namespace PixieMedia\ServerPush\Model\Output;

use PixieMedia\ServerPush\Helper\Config;
use PixieMedia\ServerPush\Model\Asset;

class AssetCollectorProcessor implements OutputProcessorInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Asset\CollectorAdapter
     */
    private $collectorAdapter;

    public function __construct(
        Config $config,
        Asset\CollectorAdapter $collectorAdapter
    ) {
        $this->config = $config;
        $this->collectorAdapter = $collectorAdapter;
    }

    public function process(string &$output): bool
    {
        if (!$this->config->isServerPushEnabled()) {
            return true;
        }

        foreach ($this->config->getServerPushAssetTypes() as $assetType) {
            $collector = $this->collectorAdapter->get($assetType);
            $collector->execute($output);
        }

        return true;
    }
}

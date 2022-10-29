<?php

declare(strict_types=1);

namespace PixieMedia\ServerPush\Model\Asset\Collector;

use Magento\Store\Model\StoreManagerInterface;
use PixieMedia\ServerPush\Model\Asset\AssetCollectorInterface;

abstract class AbstractAssetCollector implements AssetCollectorInterface
{
    /**
     * Must be overridden in child classes
     * Use a <asset_url> regex group name for asset urls
     */
    public const REGEX = '';

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var array
     */
    protected $collectedAssets = [];

    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    abstract public function getAssetContentType(): string;

    public function getCollectedAssets(): array
    {
        return $this->collectedAssets;
    }

    public function execute(string $output)
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl('static');

        if (!empty(static::REGEX) && preg_match_all(static::REGEX, $output, $assets)) {
            foreach ($assets['asset_url'] ?? [] as $assetUrl) {
                if (strstr($assetUrl, $baseUrl)) {
                    $this->collectedAssets[] = $assetUrl;
                }
            }
        }
    }
}

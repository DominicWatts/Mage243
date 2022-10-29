<?php

namespace PixieMedia\ServerPush\Model\Asset\Collector;

use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Theme\Block\Html\Header\Logo;
use PixieMedia\ServerPush\Model\Asset\AssetCollectorInterface;

class PreloadImageCollector implements AssetCollectorInterface
{
    public const REGEX = '';

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Logo
     */
    private $logo;

    /**
     * @var array
     */
    private $collectedAssets = [];

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Theme\Block\Html\Header\Logo $logo
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Logo $logo
    ) {
        $this->storeManager = $storeManager;
        $this->logo = $logo;
    }

    public function getAssetContentType(): string
    {
        return 'image';
    }

    public function getCollectedAssets(): array
    {
        return $this->collectedAssets;
    }

    public function execute(string $output)
    {
        $this->addImageAsset($this->logo->getLogoSrc());
    }

    public function addImageAsset(string $assetUrl)
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB);

        if (strstr($assetUrl, $baseUrl)) {
            $this->collectedAssets[] = $assetUrl;
        }
    }
}

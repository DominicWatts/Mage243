<?php

namespace PixieMedia\ServerPush\Model\OptionSource;

use Magento\Framework\Data\OptionSourceInterface;

class ServerPushAssetTypes implements OptionSourceInterface
{
    /**
     * @var array
     */
    private $assetTypes;

    public function __construct(array $assetTypes = [])
    {
        $this->assetTypes = $assetTypes;
    }

    public function toOptionArray()
    {
        $optionArray = [];

        foreach ($this->assetTypes as $assetType => $label) {
            $optionArray[] = ['value' => $assetType, 'label' => $label];
        }

        return $optionArray;
    }
}

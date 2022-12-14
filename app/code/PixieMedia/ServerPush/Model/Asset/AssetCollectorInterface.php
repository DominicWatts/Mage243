<?php

namespace PixieMedia\ServerPush\Model\Asset;

interface AssetCollectorInterface
{
    public function getAssetContentType(): string;

    public function getCollectedAssets(): array;

    public function execute(string $output);
}

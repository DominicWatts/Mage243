<?php

declare(strict_types=1);

namespace PixieMedia\ServerPush\Model\Asset\Collector;

class FontCollector extends AbstractAssetCollector
{
    public const REGEX = '/<link[^>]*href\s*=\s*["|\'](?<asset_url>.*?(eot|fft|otf|woff2|woff))["\']+[^>]*>/i';

    public function getAssetContentType(): string
    {
        return 'font';
    }
}

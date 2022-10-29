<?php

declare(strict_types=1);

namespace PixieMedia\ServerPush\Model\Asset\Collector;

class CssCollector extends AbstractAssetCollector
{
    public const REGEX = '/<link[^>]*href\s*=\s*["|\'](?<asset_url>[^"\']*\.css[^"\']*)["\']+[^>]*>/is';

    public function getAssetContentType(): string
    {
        return 'style';
    }
}

<?php

declare(strict_types=1);

namespace PixieMedia\ServerPush\Model\Asset\Collector;

class JsCollector extends AbstractAssetCollector
{
    public const REGEX = '/<script[^>]*?src\s*=\s*["|\'](?<asset_url>[^"\']*\.js[^"\']*)["\']+[^>]*?><\/script>/is';

    public function getAssetContentType(): string
    {
        return 'script';
    }
}

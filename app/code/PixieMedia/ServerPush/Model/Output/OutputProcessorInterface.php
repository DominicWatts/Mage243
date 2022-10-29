<?php

declare(strict_types=1);

namespace PixieMedia\ServerPush\Model\Output;

interface OutputProcessorInterface
{
    /**
     * @param string &$output
     *
     * @return bool
     */
    public function process(string &$output): bool;
}

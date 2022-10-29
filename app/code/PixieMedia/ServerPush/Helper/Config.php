<?php

/**
 * Copyright © 2022 All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace PixieMedia\ServerPush\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    public const SERVER_PUSH_ENABLED = 'general/enabled';
    public const SERVER_PUSH_TYPES = 'general/server_push_types';
    public const SERVER_PUSH_EXCLUDE = 'general/server_push_exclude';

    /**
     * Stored values by scopes
     *
     * @var array
     */
    protected $data = [];

    /**
     * xpath prefix of module (section)
     * @var string '{section}/'
     */
    protected $pathPrefix = 'serverpush/';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        if ($this->pathPrefix === '/') {
            throw new \LogicException('$pathPrefix should be declared');
        }
        parent::__construct($context);
    }

    public function isServerPushEnabled(): bool
    {
        return $this->isSetFlag(self::SERVER_PUSH_ENABLED);
    }

    public function getServerPushAssetTypes(): array
    {
        $assetTypes = (string)$this->getValue(self::SERVER_PUSH_TYPES);

        return array_filter(explode(',', $assetTypes));
    }

    public function getServerPushIgnoreList()
    {
        return $this->convertStringToArray($this->getValue(self::SERVER_PUSH_EXCLUDE));
    }

    /**
     * An alias for scope config with default scope type SCOPE_STORE
     *
     * @param string $path '{group}/{field}'
     * @param int|ScopeInterface|null $storeId Scope code
     * @param string $scope
     *
     * @return mixed
     */
    protected function getValue(
        $path,
        $storeId = null,
        $scope = ScopeInterface::SCOPE_STORE
    ) {
        if ($storeId === null && $scope !== ScopeConfigInterface::SCOPE_TYPE_DEFAULT) {
            return $this->scopeConfig->getValue($this->pathPrefix . $path, $scope, $storeId);
        }

        if ($storeId instanceof \Magento\Framework\App\ScopeInterface) {
            $storeId = $storeId->getId();
        }
        $scopeKey = $storeId . $scope;
        if (!isset($this->data[$path]) || !\array_key_exists($scopeKey, $this->data[$path])) {
            $this->data[$path][$scopeKey] = $this->scopeConfig->getValue($this->pathPrefix . $path, $scope, $storeId);
        }

        return $this->data[$path][$scopeKey];
    }

    /**
     * @param string $path '{group}/{field}'
     * @param int|ScopeInterface|null $storeId
     * @param string $scope
     *
     * @return bool
     */
    protected function isSetFlag(
        $path,
        $storeId = null,
        $scope = ScopeInterface::SCOPE_STORE
    ) {
        return (bool)$this->getValue($path, $storeId, $scope);
    }

    /**
     * @param string $data
     * @param string $separator
     *
     * @return array
     */
    public function convertStringToArray($data, $separator = PHP_EOL)
    {
        if (empty($data)) {
            return [];
        }

        return array_filter(array_map('trim', explode($separator, $data)));
    }

    /**
     * clear local storage
     *
     * @return void
     */
    public function clean()
    {
        $this->data = [];
    }
}

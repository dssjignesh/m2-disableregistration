<?php

declare(strict_types=1);
/**
 * Digit Software Solutions.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  Dss
 * @package   Dss_DisableRegistration
 * @author    Extension Team
 * @copyright Copyright (c) 2024 Digit Software Solutions. ( https://digitsoftsol.com )
 */
namespace Dss\DisableRegistration\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    public const XML_PATH_ENABLED = 'dss_disableregistration/general/enabled';
    public const XML_PATH_DEBUG = 'dss_disableregistration/general/debug';
    public const XML_PATH_REGISTRATION_OPTION = 'dss_disableregistration/registration/registration_option';
    public const XML_PATH_REGISTRATION_SHOW_MESSAGE = 'dss_disableregistration/registration/enable_disabled_message';
    public const XML_PATH_REGISTRATION_DISABLED_MESSAGE = 'dss_disableregistration/registration/disabled_message';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        protected ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Retrieve configuration flag.
     *
     * @param string $xmlPath
     * @param int|null $storeId
     * @return bool
     */
    public function getConfigFlag($xmlPath, $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Retrieve configuration value.
     *
     * @param string $xmlPath
     * @param int|null $storeId
     * @return string
     */
    public function getConfigValue($xmlPath, $storeId = null): string
    {
        return $this->scopeConfig->getValue(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if the module is enabled.
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled($storeId = null): bool
    {
        return $this->getConfigFlag(self::XML_PATH_ENABLED, $storeId);
    }

    /**
     * Check if debug mode is enabled.
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isDebugEnabled($storeId = null): bool
    {
        return $this->getConfigFlag(self::XML_PATH_DEBUG, $storeId);
    }

    /**
     * Retrieve the registration option.
     *
     * @param int|null $storeId
     * @return mixed
     */
    public function getRegistrationOption($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_REGISTRATION_OPTION, $storeId);
    }

    /**
     * Check if the registration disabled message should be shown.
     *
     * @param int|null $storeId
     * @return mixed
     */
    public function showRegistrationDisabledMessage($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_REGISTRATION_SHOW_MESSAGE, $storeId);
    }

    /**
     * Retrieve the registration disabled message.
     *
     * @param int|null $storeId
     * @return mixed
     */
    public function getRegistrationDisabledMessage($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_REGISTRATION_DISABLED_MESSAGE, $storeId);
    }
}

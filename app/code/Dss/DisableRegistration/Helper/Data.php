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
namespace Dss\DisableRegistration\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Module\ModuleListInterface;
use Dss\DisableRegistration\Logger\Logger as ModuleLogger;
use Dss\DisableRegistration\Model\Config;
use Dss\DisableRegistration\Model\System\Config\Source\RegistrationOption;

class Data extends AbstractHelper
{
    /**
     * @param Context $context
     * @param ModuleLogger $moduleLogger
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     * @param ModuleListInterface $moduleList
     */
    public function __construct(
        Context $context,
        protected ModuleLogger $moduleLogger,
        protected Config $config,
        protected StoreManagerInterface $storeManager,
        protected ModuleListInterface $moduleList
    ) {
        parent::__construct($context);
    }

    /**
     * Get config helper
     *
     * @return Config
     */
    public function getConfigHelper(): Config
    {
        return $this->config;
    }

    /**
     * Get extension version
     *
     * @return string
     */
    public function getExtensionVersion(): string
    {
        $moduleCode = 'Dss_DisableRegistration';
        $moduleInfo = $this->moduleList->getOne($moduleCode);
        return $moduleInfo['setup_version'];
    }

    /**
     * Get base URL
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_WEB,
            true
        );
    }

    /**
     * Check if the module is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->config->isEnabled();
    }

    /**
     * Check if registration is disabled
     *
     * @return bool
     */
    public function isRegistrationDisabled(): bool
    {
        return $this->config->getRegistrationOption() == RegistrationOption::DISABLED;
    }

    /**
     * Check if the registration disabled message should be shown
     *
     * @return string
     */
    public function showRegistrationDisabledMessage(): string
    {
        return $this->config->showRegistrationDisabledMessage();
    }

    /**
     * Logging Utility
     *
     * @param string $message
     * @param bool $useSeparator
     */
    public function log(string $message, bool $useSeparator = false)
    {
        if ($this->isActive()
            && $this->config->isDebugEnabled()
        ) {
            if ($useSeparator) {
                $this->moduleLogger->customLog(str_repeat('=', 100));
            }

            $this->moduleLogger->customLog($message);
        }
    }
}

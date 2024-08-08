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
namespace Dss\DisableRegistration\Plugin\Customer\Model;

use Magento\Customer\Model\Registration;
use Dss\DisableRegistration\Helper\Data as DisableRegistrationHelper;

class DisableRegistrationPlugin
{
    /**
     * @param DisableRegistrationHelper $helper
     */
    public function __construct(
        protected DisableRegistrationHelper $helper
    ) {
    }

    /**
     * Plugin to disable customer registration.
     *
     * @param Registration $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsAllowed(
        Registration $subject,
        $result
    ) {
        $this->helper->log(__METHOD__, true);
        if ($this->helper->isActive()
            && $this->helper->isRegistrationDisabled()
        ) {
            return false;
        }
        return true;
    }
}

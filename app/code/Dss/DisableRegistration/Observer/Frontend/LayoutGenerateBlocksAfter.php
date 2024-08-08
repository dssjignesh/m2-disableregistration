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
namespace Dss\DisableRegistration\Observer\Frontend;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Dss\DisableRegistration\Helper\Data as DisableRegistrationHelper;

class LayoutGenerateBlocksAfter implements ObserverInterface
{
    protected const TEMPLATE_FOR_CUSTOMER_NEW = 'Dss_DisableRegistration::customer/newcustomer.phtml';
    protected const CUSTOMER_LOGIN_PAGE_FULL_ACTION = 'customer_account_login';

    /**
     * @param DisableRegistrationHelper $helper
     */
    public function __construct(
        protected DisableRegistrationHelper $helper
    ) {
    }

    /**
     * Execute observer.
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $this->helper->log(__METHOD__, true);
        if (!$this->helper->isActive()
            || !$this->helper->isRegistrationDisabled()
            || !$this->helper->showRegistrationDisabledMessage()
        ) {
            return $this;
        }

        $fullActionName = $observer->getFullActionName();

        if (!in_array(
            $fullActionName,
            [
                    self::CUSTOMER_LOGIN_PAGE_FULL_ACTION
                ]
        )
        ) {
            return $this;
        }

        $layout = $observer->getLayout();
        if ($customerNewBlock = $layout->getBlock('customer.new')) {
            $customerNewBlock->setTemplate(self::TEMPLATE_FOR_CUSTOMER_NEW);
            $customerNewBlock->setData(
                'mp_registration_disabled_message',
                $this->helper->getConfigHelper()->getRegistrationDisabledMessage()
            );
        }
    }
}

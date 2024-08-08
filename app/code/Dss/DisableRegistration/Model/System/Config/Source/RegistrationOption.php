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
namespace Dss\DisableRegistration\Model\System\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class RegistrationOption implements OptionSourceInterface
{
    /** @var int */
    public const ENABLED = 1;

    /** @var int */
    public const DISABLED = 0;

    /** @var array */
    protected $_options;

    /**
     * Retrieve all options for the source.
     *
     * @param bool $withEmpty Whether to include an empty option
     * @return array
     */
    public function getAllOptions($withEmpty = false): array
    {
        if ($this->_options === null) {
            $this->_options = [
                [
                    'value' => self::ENABLED,
                    'label' => __('Enabled'),
                ],

                [
                    'value' => self::DISABLED,
                    'label' => __('Disabled'),
                ],
            ];

        }
        $options = $this->_options;
        if ($withEmpty) {
            array_unshift($options, ['value' => '', 'label' => '']);
        }
        return $options;
    }

    /**
     * Retrieve options as a key-value pair array.
     *
     * @param bool $withEmpty Whether to include an empty option
     * @return array
     */
    public function getOptionsArray($withEmpty = true): array
    {
        $options = [];
        foreach ($this->getAllOptions($withEmpty) as $option) {
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }

    /**
     * Retrieve the label for a specific option value.
     *
     * @param int $value
     * @return string|false
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions(false);
        foreach ($options as $item) {
            if ($item['value'] == $value) {
                return $item['label'];
            }
        }
        return false;
    }

    /**
     * Convert options to a format compatible with Magento's option array.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return $this->getAllOptions();
    }

    /**
     * Convert options to a key-value hash.
     *
     * @param bool $withEmpty Whether to include an empty option
     * @return array
     */
    public function toOptionHash($withEmpty = true): array
    {
        return $this->getOptionsArray($withEmpty);
    }
}

<?php
/**
 * Ecomteck
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the ecomteck.com license that is
 * available through the world-wide-web at this URL:
 * https://ecomteck.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Ecomteck
 * @package     Ecomteck_ProductSliderGraphQl
 * @copyright   Copyright (c) 2019 Ecomteck (https://ecomteck.com/)
 * @license     https://ecomteck.com/LICENSE.txt
 */
declare(strict_types=1);

namespace Ecomteck\ProductSliderGraphQl\Model\Resolver;

use Ecomteck\ProductSliderGraphQl\Model\Resolver\DataProvider\Slider as SliderDataProvider;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Class Slider
 * @package Ecomteck\ProductSliderGraphQl\Model\Resolver
 */
class Slider implements ResolverInterface
{
    /**
     * @var SliderDataProvider
     */
    private $sliderDataProvider;

    /**
     * Slider constructor.
     * @param SliderDataProvider $sliderDataProvider
     */
    public function __construct(SliderDataProvider $sliderDataProvider)
    {
        $this->sliderDataProvider = $sliderDataProvider;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $sliderId = $this->getSliderId($args);
        $sliderData = $this->getSliderData($sliderId);

        return $sliderData;
    }

    /**
     * @param array $args
     * @return int
     * @throws GraphQlInputException
     */
    private function getSliderId(array $args): int
    {
        if (!isset($args['id'])) {
            throw new GraphQlInputException(__('"Slider id should be specified'));
        }

        return (int)$args['id'];
    }

    /**
     * @param int $sliderId
     * @return array
     * @throws GraphQlNoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getSliderData(int $sliderId): array
    {
        try {
            $sliderData = $this->sliderDataProvider->getData($sliderId);
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $sliderData;
    }
}

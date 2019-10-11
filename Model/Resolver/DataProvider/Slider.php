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

namespace Ecomteck\ProductSliderGraphQl\Model\Resolver\DataProvider;

use Ecomteck\ProductSlider\Api\Data\SliderInterface;
use Ecomteck\ProductSlider\Api\SliderRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Product slider data provider
 */
class Slider
{
    /**
     * @var SliderRepositoryInterface
     */
    private $sliderRepository;

    /**
     * @param SliderRepositoryInterface $sliderRepository
     */
    public function __construct(
        SliderRepositoryInterface $sliderRepository
    ) {
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * @param int $sliderId
     * @return array
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getData(int $sliderId): array
    {
        $slider = $this->sliderRepository->getById($sliderId);

        if (false === $slider->getStatus()) {
            throw new NoSuchEntityException();
        }

        $sliderData = [
            SliderInterface::SLIDER_ID => $slider->getId(),
            SliderInterface::NAME => $slider->getName(),
            SliderInterface::STATUS => $slider->getStatus(),
            SliderInterface::TITLE => $slider->getTitle(),
            SliderInterface::DESCRIPTION => $slider->getDescription(),
            SliderInterface::STORE_IDS => $slider->getStoreIds(),
            SliderInterface::CUSTOMER_GROUP_IDS => $slider->getCustomerGroupIds(),
            SliderInterface::LIMIT_NUMBER => $slider->getLimitNumber(),
            SliderInterface::LOCATION => $slider->getLocation(),
            SliderInterface::TIME_CACHE => $slider->getTimeCache(),
            SliderInterface::FROM_DATE => $slider->getFromDate(),
            SliderInterface::TO_DATE => $slider->getToDate(),
            SliderInterface::PRODUCT_TYPE => $slider->getProductType(),
            SliderInterface::CATEGORIES_IDS => $slider->getCategoryIds(),
            SliderInterface::PRODUCT_IDS => $slider->getProductIds(),
            SliderInterface::DISPLAY_ADDITIONAL => $slider->getDisplayAdditional(),
            SliderInterface::IS_RESPONSIVE => $slider->getIsResponsive(),
            SliderInterface::RESPONSIVE_ITEMS => $slider->getResponsiveItems(),
            SliderInterface::CREATED_AT => $slider->getCreatedAt(),
            SliderInterface::UPDATED_AT => $slider->getUpdatedAt()
        ];
        return $sliderData;
    }
}

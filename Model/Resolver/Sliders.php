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

use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\Builder as SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Ecomteck\ProductSlider\Api\SliderRepositoryInterface;

/**
 * Class Sliders
 * @package Ecomteck\ProductSliderGraphQl\Model\Resolver
 */
class Sliders implements ResolverInterface
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SliderRepositoryInterface
     */
    private $sliderRepository;

    /**
     * Posts constructor.
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SliderRepositoryInterface $sliderRepository
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SliderRepositoryInterface $sliderRepository
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sliderRepository = $sliderRepository;
    }
    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $searchCriteria = $this->searchCriteriaBuilder->build('di_build_slider_field_filter', $args);
        $searchCriteria->setCurrentPage($args['currentPage']);
        $searchCriteria->setPageSize($args['pageSize']);

        $searchResult = $this->sliderRepository->getList($searchCriteria);
        return [
            'total_count' => $searchResult->getTotalCount(),
            'items' => $searchResult->getItems()
        ];
    }
}

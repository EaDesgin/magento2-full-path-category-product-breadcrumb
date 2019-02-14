<?php
/**
 * Copyright © EAdesign by Eco Active S.R.L.,All rights reserved.
 * See LICENSE for license details.
 */
namespace Eadesigndev\FullBreadcrumbs\Block;

use Magento\Catalog\Helper\Data;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\Api\AttributeValue;
use Eadesigndev\FullBreadcrumbs\Helper\Data as BreadcrumbsData;

class FullBreadcrumbs extends \Magento\Framework\View\Element\Template
{
    /**
     * Catalog data
     *
     * @var Data
     */
    private $catalogData = null;
    private $registry;
    private $categoryCollection;
    private $breadcrumbsData;
    public $bad_categories;
    public $enabled;

    /**
     * @param Context $context
     * @param Data $catalogData
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $catalogData,
        Registry $registry,
        BreadcrumbsData $breadcrumbsData,
        CollectionFactory $categoryCollection,
        array $data = []
    ) {
        $this->catalogData = $catalogData;
        $this->registry = $registry;
        $this->breadcrumbsData = $breadcrumbsData;
        $this->categoryCollection = $categoryCollection;
        parent::__construct($context, $data);
    }

    public function getBadCategories()
    {
        $bad_categories = $this->breadcrumbsData->hasConfig('ea_fullbreadcrumbs/fullbreadcrumbs/bad_categories');
        return explode(',', str_replace(' ', '', $bad_categories));
    }

    public function isEnable()
    {
        return $this->breadcrumbsData->hasConfig('ea_fullbreadcrumbs/fullbreadcrumbs/enabled');
    }

    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function getCategoryProductIds($product)
    {
        /** @var  $categoryIds  AttributeValue */
        $categoryIds = $product->getCategoryIds();
        return $categoryIds;
    }

    public function getFilteredCollection($categoryIds)
    {
        $collection = $this->categoryCollection->create();
        $filtered_colection = $collection
            ->addFieldToSelect('*')
            ->addFieldToFilter(
                'entity_id',
                ['in' => $categoryIds]
            )
            ->setOrder('level', 'ASC')
            ->load();
        return $filtered_colection;
    }

    public function getCategories($filtered_colection, $badCategories)
    {
        $separator = ' <span class="breadcrumbsseparator"></span> ';
        $categories = '';
        foreach ($filtered_colection as $categoriesData) {
            if (!in_array($categoriesData->getId(), $badCategories)) {
                $categories .= '<a href="' . $categoriesData->getUrl() . '">';
                $categories .= $categoriesData->getData('name') . '</a>' . $separator;
            }
        }
        return $categories;
    }

    public function getProductBreadcrumbs()
    {
        if ($this->isEnable()) {
            $separator = ' <span class="breadcrumbsseparator"></span> ';
            $product = $this->getProduct();
            $categoryIds = $this->getCategoryProductIds($product);

            $filtered_colection = $this->getFilteredCollection($categoryIds);

            $badCategories = $this->getBadCategories();

            $categories = $this->getCategories($filtered_colection, $badCategories);

            $home_url = '<a href="' . $this->_storeManager->getStore()->getBaseUrl() . '">Home</a>';
            return $home_url . $separator . $categories . '<span>' . $product->getName() . '</span>';
        }
    }
}

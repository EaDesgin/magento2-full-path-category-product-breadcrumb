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
        return $this->breadcrumbsData->hasConfig('ea_fullbreadcrumbs/fullbreadcrumbs/bad_categories');
    }

    public function isEnable()
    {
        return $this->breadcrumbsData->hasConfig('ea_fullbreadcrumbs/fullbreadcrumbs/enabled');
    }





    public function getProductBreadcrumbs()
    {
        $bad_categories = $this->getBadCategories();
        $enabled = $this->isEnable();

        if ($enabled) {
            $bad_categories_array = explode(',', str_replace(' ', '', $bad_categories));
            $separator = ' <span class="breadcrumbsseparator"></span> ';
            $product = $this->registry->registry('current_product');
            /** @var  $categoryIds  AttributeValue */
            $categoryIds = $product->getCustomAttribute('category_ids')->getValue();

            $collection = $this->categoryCollection->create();
            $filtered_colection = $collection
                ->addFieldToSelect('*')
                ->addFieldToFilter(
                    'entity_id',
                    ['in' => $categoryIds]
                )
                ->setOrder('level', 'ASC')
                ->load();

            $categories = '';
            foreach ($filtered_colection as $categoriesData) {
                if (!in_array($categoriesData->getId(), $bad_categories_array)) {
                    $categories .= '<a href="' . $categoriesData->getUrl() . '">';
                    $categories .= $categoriesData->getData('name') . '</a>' . $separator;
                }
            }
            $home_url = '<a href="' . $this->_storeManager->getStore()->getBaseUrl() . '">Home</a>';
            return $home_url . $separator . $categories . '<span>' . $product->getName() . '</span>';
        }
    }
}

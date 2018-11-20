<?php
namespace Eadesigndev\FullBreadcrumbs\Block;

use Magento\Catalog\Helper\Data;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\Api\AttributeValue;

class FullBreadcrumbs extends \Magento\Framework\View\Element\Template
{
    /**
     * Catalog data
     *
     * @var Data
     */
    protected $catalogData = null;
    private $registry;
    private $categoryCollection;

    /**
     * @param Context $context
     * @param Data $catalogData
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $catalogData,
        Registry $registry,
        CollectionFactory $categoryCollection,
        array $data = []
    ) {
        $this->catalogData = $catalogData;
        $this->registry = $registry;
        $this->categoryCollection = $categoryCollection;
        parent::__construct($context, $data);
    }

    public function getProductBreadcrumbs($bad_categories, $enabled)
    {
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
            $home_url = '<a href="' . $this->_storeManager->getStore()->getBaseUrl() . '">Magazie</a>';
            return $home_url . $separator . $categories . '<span>' . $product->getName() . '</span>';
        }
    }
}

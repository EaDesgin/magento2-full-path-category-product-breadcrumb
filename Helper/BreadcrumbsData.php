<?php
namespace Eadesigndev\FullBreadcrumbs\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class BreadcrumbsData extends AbstractHelper
{
    const ENABLED = 'ea_fullbreadcrumbs/fullbreadcrumbs/enabled';

    /**
     * @var ScopeConfigInterface
     */
    public $config;

    /**
     * Data constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->config = $context->getScopeConfig();
        parent::__construct($context);
    }

    /**
     * @param string $configPath
     * @return bool
     */
    public function getConfig($configPath)
    {
        return $this->config->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function isEnabled($enablefullbreadcrumbs = self::ENABLED)
    {
        return $this->getConfig($enablefullbreadcrumbs);
    }
}

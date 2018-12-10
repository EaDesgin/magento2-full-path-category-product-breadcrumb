<?php
namespace Eadesigndev\FullBreadcrumbs\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const ENABLED = 'ea_fullbreadcrumbs/fullbreadcrumbs/enabled';

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
    public function hasConfig($configPath)
    {
        return $this->config->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function isEnabled($enablefullbreadcrumbs = self::ENABLED)
    {
        return $this->hasConfig($enablefullbreadcrumbs);
    }
}

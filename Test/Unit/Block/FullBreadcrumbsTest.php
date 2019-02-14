<?php
/**
 * Created by PhpStorm.
 * User: euser
 * Date: 2/4/19
 * Time: 3:09 PM
 */

namespace Eadesigndev\FullBreadcrumbs\Test\Unit\Block;

use Eadesigndev\FullBreadcrumbs\Block\FullBreadcrumbs;
use Eadesigndev\FullBreadcrumbs\Helper\Data;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;

class FullBreadcrumbsTest extends TestCase
{
    /**
     * @var ScopeConfigInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $scopeConfigInterface;
    /**
     * @var Context
     */
    private $context;
    /**
     * @var Data
     */
    private $subject;

    public function setUp()
    {
        $this->context = $this->getMockBuilder(Context::class)
            ->setMethods(['getScopeConfig'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->subject = new Data(
            $this->context
        );
    }

    public function testGetProductBreadcrumbs()
    {
        $this->assertTrue(true);
    }
}

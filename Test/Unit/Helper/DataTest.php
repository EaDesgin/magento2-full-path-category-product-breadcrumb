<?php
/**
 * Created by PhpStorm.
 * User: euser
 * Date: 2/4/19
 * Time: 1:29 PM
 */

namespace Eadesigndev\FullBreadcrumbs\Test\Unit\Helper;

use Eadesigndev\FullBreadcrumbs\Helper\Data;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;

class DataTest extends TestCase
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

        $this->scopeConfigInterface = $this->getMockBuilder(ScopeConfigInterface::class)
            ->setMethods(['getValue', 'isSetFlag'])
            ->getMockForAbstractClass();

        $this->context
            ->expects($this->atLeastOnce())
            ->method('getScopeConfig')
            ->will($this->returnValue($this->scopeConfigInterface));

        $this->subject = new Data(
            $this->context,
            $this->scopeConfigInterface
        );
    }

    public function testHasConfig()
    {
        $scope = $this->scopeConfigInterface;

        $scope->expects($this->exactly(1))
            ->method('getValue')
            ->willReturn(true);

        $this->assertTrue($this->subject->hasConfig('ea_fullbreadcrumbs/fullbreadcrumbs/enabled'));
    }

    public function testIsEnabled()
    {
        $scope = $this->scopeConfigInterface;

        $scope->expects($this->once())
            ->method('getValue')->willReturn(true);

        $this->assertTrue($this->subject->isEnabled());
    }
}

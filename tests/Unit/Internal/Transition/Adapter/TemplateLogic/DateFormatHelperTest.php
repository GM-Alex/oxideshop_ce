<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Transition\Adapter\TemplateLogic;

use OxidEsales\EshopCommunity\Internal\Transition\Adapter\TemplateLogic\DateFormatHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateFormatHelper::class, 'fixWindowsTimeFormat')]
class DateFormatHelperTest extends TestCase
{
    public static function provider(): array
    {
        return [
            ['%D %h %n %r %R %t %T', 1543850519, "%m/%d/%y %b 
 %I:%M:%S %p %H:%M 	 %H:%M:%S"],
            ['%T %t %R %r %n %h %D', 1543850519, "%H:%M:%S 	 %H:%M %I:%M:%S %p 
 %b %m/%d/%y"],
            ['%e', 691200, " 9"],
            ['%l', 46800, " 2"],
            ['foo', '', "foo"],
        ];
    }

    #[DataProvider('provider')]
    public function testFixWindowsTimeFormat($format, $timestamp, $expectedFormat)
    {
        $dateFormatHelper = new DateFormatHelper();
        $actualFormat = $dateFormatHelper->fixWindowsTimeFormat($format, $timestamp);
        $this->assertEquals($expectedFormat, $actualFormat);
    }
}

<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Framework\Module\Converter\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\MetaData\Validator\MetaDataValidatorAggregate;
use OxidEsales\EshopCommunity\Internal\Framework\Module\MetaData\Validator\MetaDataValidatorInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MetaDataValidatorAggregate::class)]
class MetaDataValidatorAggregateTest extends TestCase
{
    public function testValidate(): void
    {
        $this->expectException(\Exception::class);

        $validatorStub = $this->getMockBuilder(MetaDataValidatorInterface::class)->getMock();
        $validatorStub->method('validate')->willThrowException(new \Exception());

        (new MetaDataValidatorAggregate($validatorStub))->validate(['any']);
    }
}

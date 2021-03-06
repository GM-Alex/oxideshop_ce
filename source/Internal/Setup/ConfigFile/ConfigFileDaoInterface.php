<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Setup\ConfigFile;

interface ConfigFileDaoInterface
{
    /**
     * @param string $placeholderName
     * @param string $value
     * @throws ConfigFileNotFoundException
     */
    public function replacePlaceholder(string $placeholderName, string $value): void;
}

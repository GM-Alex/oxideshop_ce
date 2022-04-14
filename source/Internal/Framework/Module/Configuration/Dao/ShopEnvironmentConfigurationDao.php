<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao;

use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Storage\FileStorageFactoryInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\NodeInterface;
use Symfony\Component\Filesystem\Filesystem;

class ShopEnvironmentConfigurationDao implements ShopEnvironmentConfigurationDaoInterface
{
    /**
     * ShopConfigurationDao constructor.
     */
    public function __construct(private FileStorageFactoryInterface $fileStorageFactory, private Filesystem $fileSystem, private NodeInterface $node, private BasicContextInterface $context)
    {
    }

    /**
     * @param int $shopId
     *
     * @return array
     */
    public function get(int $shopId): array
    {
        $data = [];

        $configurationFilePath = $this->getEnvironmentConfigurationFilePath($shopId);

        if ($this->fileSystem->exists($configurationFilePath)) {
            $storage = $this->fileStorageFactory->create(
                $this->getEnvironmentConfigurationFilePath($shopId)
            );

            try {
                $data = $this->node->normalize($storage->get());
            } catch (InvalidConfigurationException $exception) {
                throw new InvalidConfigurationException(
                    'File ' .
                    $this->getEnvironmentConfigurationFilePath($shopId) .
                    ' is broken: ' . $exception->getMessage()
                );
            }
        }

        return $data;
    }

    /**
     * backup environment configuration file
     *
     * @param int $shopId
     */
    public function remove(int $shopId): void
    {
        $path = $this->getEnvironmentConfigurationFilePath($shopId);

        if ($this->fileSystem->exists($path)) {
            $this->fileSystem->rename($path, $path . '.bak', true);
        }
    }

    /**
     * @param int $shopId
     *
     * @return string
     */
    private function getEnvironmentConfigurationFilePath(int $shopId): string
    {
        return $this->context->getProjectConfigurationDirectory() . 'environment/' . $shopId . '.yaml';
    }
}

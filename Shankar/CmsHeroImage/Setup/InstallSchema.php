<?php
/**
 * Copyright (c) 2019 Shankar Konar
 */

namespace Shankar\CmsHeroImage\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package Shankar\CmsHeroImage\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();

        $connection->addColumn('cms_page','cms_hero_image',['type' =>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,'comment' => 'Store Image for each CMS page']);
        $installer->endSetup();
    }
}
<?php namespace Manager\Banner\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $connection = $setup->getConnection();
        $tableName = $setup->getTable("banner");

        if($connection->isTableExists($tableName) != true)
        {
            //identity: automatic increment
            $table = $connection->newTable($tableName)->addColumn(
                "id",
                Table::TYPE_INTEGER,
                null,
                ["primary" => true, "nullable"=>false, "identity"=>true]
            )->addColumn(
                "title",
                Table::TYPE_TEXT,
                255,
                ["nullable"=>false]
            )->addColumn(
                "content",
                Table::TYPE_TEXT,
                255,
                ["nullable"=>false]
            )->addColumn(
                "image",
                Table::TYPE_TEXT,
                255,
                ["nullable"=>false]
            )->addColumn(
                "link",
                Table::TYPE_TEXT,
                255,
                ["nullable"=>false]
            )->addColumn(
                "status",
                Table::TYPE_SMALLINT,
                2,
                ["nullable"=>false]
            )->addColumn(
                'creation_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Block Creation Time')
                ->addColumn(
                    'update_time',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Block Modification Time'
                )->setOption("charset","utf8");

            $connection->createTable($table);
        }

        $setup->endSetup();
    }

}

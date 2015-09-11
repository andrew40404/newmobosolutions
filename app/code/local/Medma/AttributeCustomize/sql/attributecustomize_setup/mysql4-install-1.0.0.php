<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn(
            $installer->getTable('catalog/eav_attribute'),
            'filterable_categories',
            array(
                'type'      =>Varien_Db_Ddl_Table::TYPE_TEXT,
                'comment'   => 'Filterable Categories',
            )
        );
$installer->endSetup();
?>


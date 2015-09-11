<?php
ini_set("display_errors",1);
class Medma_AttributeCustomize_Block_Adminhtml_Catalog_Product_Attribute_Edit_Tab_Main extends Mage_Adminhtml_Block_Catalog_Product_Attribute_Edit_Tab_Main
{
	protected function _prepareForm()
    {
		parent::_prepareForm();
		
		$form = $this->getForm();
		
		$fieldset = $form->getElement('front_fieldset');		
		$fieldset->removeField('is_filterable');
		
		$is_filterable = $fieldset->addField('is_filterable', 'select', array(
            'name' => 'is_filterable',
            'id' => 'is_filterable',
            'label' => Mage::helper('catalog')->__("Use In Layered Navigation"),
            'title' => Mage::helper('catalog')->__('Can be used only with catalog input type Dropdown, Multiple Select and Price'),
            'note' => Mage::helper('catalog')->__('Can be used only with catalog input type Dropdown, Multiple Select and Price'),
            'values' => array(
                array('value' => '0', 'label' => Mage::helper('catalog')->__('No')),
                array('value' => '1', 'label' => Mage::helper('catalog')->__('Filterable (with results)')),
                array('value' => '2', 'label' => Mage::helper('catalog')->__('Filterable (no results)')),
            ),
        ));
        
        $filterable_categories = $fieldset->addField('filterable_categories', 'multiselect', array(
			'id' => 'filterable_categories',
            'name' => 'filterable_categories[]',
            'label' => Mage::helper('catalog')->__("Layered Navigation apply on selected categories"),
            'title' => Mage::helper('catalog')->__('Can be used only with Layered Navigation'),
            'note' => Mage::helper('catalog')->__('Can be used only with Layered Navigation'),
            'values' => Mage::getModel('attributecustomize/category_list')->getAllOptions(),
        ));
        
        $filterable_categories->setAfterElementHtml('<script type="text/javascript">
			$("is_filterable").onchange = on_change_is_filterable;
			on_change_is_filterable();
			function on_change_is_filterable() {		
				$("filterable_categories").up().up().style.display = ($("is_filterable").getValue() == 0? "none": "table-row");
			}
        </script>');
        
        $attributeObject = $this->getAttributeObject();
        $filterable_categories_values = $attributeObject->getFilterableCategories();
        
        if(isset($filterable_categories_values) && $filterable_categories_values != '')
        {
			$form->getElement('filterable_categories')->setValue($filterable_categories_values);
		}
	}
}
?>

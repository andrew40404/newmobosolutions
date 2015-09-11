<?php
ini_set("display_errors",1);
class Medma_AttributeCustomize_Model_Category_List extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{	
	public function getAllOptions()
    {
		$store = Mage::getModel('core/store')->load(Mage_Core_Model_App::DISTRO_STORE_ID);
		
		$rootId = $store->getRootCategoryId();
		
		$category_array = array();
		
		$this->_getCategory($category_array, $rootId);
		
		//echo '<pre>';print_r($category_array);die("died");		
		return $category_array;
	}
	
	protected function _getCategory(&$category_array, $categoryId)
	{
		$categories = Mage::getModel('catalog/category')->getCategories($categoryId);
		
		foreach($categories as $category) {
			$category_array[$category->getEntityId()] = array(
				'value' => $category->getId(),
                'label' => str_repeat("-", (($category->getLevel() - 2) * 2)). ' ' . $category->getName(),
            );
			
			if($category->hasChildren())
				$this->_getCategory($category_array, $category->getId());
		}
	}
}
?>

<?php
class Medma_AttributeCustomize_Model_Catalog_Layer_Filter_Attribute extends Mage_Catalog_Model_Layer_Filter_Attribute
{
	protected function _getItemsData()
    {
        $attribute = $this->getAttributeModel();
        $this->_requestVar = $attribute->getAttributeCode();

		$getFilterableCategories = explode(",", $attribute->getFilterableCategories());
		$currentCategoryId = $this->getLayer()->getCurrentCategory()->getId();
		
		if(!in_array($currentCategoryId, $getFilterableCategories))
			return array();
			
        $key = $this->getLayer()->getStateKey().'_'.$this->_requestVar;
        $data = $this->getLayer()->getAggregator()->getCacheData($key);

        if ($data === null) {
            $options = $attribute->getFrontend()->getSelectOptions();
            $optionsCount = $this->_getResource()->getCount($this);
            $data = array();
            foreach ($options as $option) {
                if (is_array($option['value'])) {
                    continue;
                }
                if (Mage::helper('core/string')->strlen($option['value'])) {
                    // Check filter type
                    if ($this->_getIsFilterableAttribute($attribute) == self::OPTIONS_ONLY_WITH_RESULTS) {					
						if (!empty($optionsCount[$option['value']])) {
							$data[] = array(
								'label' => $option['label'],
								'value' => $option['value'],
								'count' => $optionsCount[$option['value']],
							);
						}
                    }
                    else {
                        $data[] = array(
                            'label' => $option['label'],
                            'value' => $option['value'],
                            'count' => isset($optionsCount[$option['value']]) ? $optionsCount[$option['value']] : 0,
                        );
                    }
                }
            }

            $tags = array(
                Mage_Eav_Model_Entity_Attribute::CACHE_TAG.':'.$attribute->getId()
            );

            $tags = $this->getLayer()->getStateTags($tags);
            $this->getLayer()->getAggregator()->saveCacheData($data, $key, $tags);
        }
        return $data;
    }
}
?>

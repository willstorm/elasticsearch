<?php
class Storm_ElasticSearch_Model_CatalogSearch_Layer extends Mage_CatalogSearch_Model_Layer
{
    /**
     * Get current layer product collection
     *
     * @return Mage_Catalog_Model_Resource_Eav_Resource_Product_Collection
     */
    public function getProductCollection()
    {
        if (isset($this->_productCollections[$this->getCurrentCategory()->getId()])) {
            $collection = $this->_productCollections[$this->getCurrentCategory()->getId()];
        } else {
            $collection = Mage::helper('catalogsearch')->getEngine()->getResultCollection();
            $this->prepareProductCollection($collection);
            $this->_productCollections[$this->getCurrentCategory()->getId()] = $collection;
        }
        return $collection;
    }
}
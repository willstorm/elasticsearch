<?php
class Storm_ElasticSearch_Model_Resource_Engine extends Mage_Core_Model_Resource
{
    protected $_api;

    public function __construct()
    {
        $this->_api = Mage::getModel('elasticsearch/api');
        return $this;
    }

    /**
     * Remove entity data from fulltext search table
     *
     * @param int $storeId
     * @param int $entityId
     * @param string $entity 'product'|'cms'
     * @return Mage_CatalogSearch_Model_Resource_Fulltext_Engine
     */
    public function cleanIndex($storeId = null, $entityId = null, $entity = 'product')
    {
        $this->_getApi()->delete($entity, array(
            'id'       => $entityId,
            'store_id' => $storeId
        ));

        return $this;
    }

    /**
     * Multi add entities data to fulltext search table
     *
     * @param int $storeId
     * @param array $entityIndexes
     * @param string $entity 'product'|'cms'
     * @return Mage_CatalogSearch_Model_Resource_Fulltext_Engine
     */
    public function saveEntityIndexes($storeId, $entityIndexes, $entity = 'product')
    {
        foreach($entityIndexes as $entityId => $index) {
            $index += array(
                'id'       => $entityId,
                'store_id' => $storeId
            );

            $this->_getApi()->add($entity, $index);
        }
        return $this;
    }

    /**
     * Prepare index array as a string glued by separator
     *
     * @param array $index
     * @param string $separator
     * @return string
     */
    public function prepareEntityIndex($index, $separator = ' ')
    {
        $_index = array();
        foreach($index as $k => $v) {
            if(empty($v)) {
                continue;
            }

            if(!is_array($v)) {
                $_index[$k] = $v;
            } else {
                $_index[$k] = join(', ', array_unique($v));
            }
        }

        return $_index;
    }

    /**
     * Retrieve allowed visibility values for current engine
     *
     * @return array
     */
    public function getAllowedVisibility()
    {
        return Mage::getSingleton('catalog/product_visibility')->getVisibleInSearchIds();
    }

    /**
     * Define if current search engine supports advanced index
     *
     * @return bool
     */
    public function allowAdvancedIndex()
    {
        return false;
    }

    /**
     * Define if Layered Navigation is allowed
     *
     * @return bool
     */
    public function isLeyeredNavigationAllowed()
    {
        return true;
    }

    /**
     * Perform a connection test to elastic search server
     *
     * @return bool
     */
    public function test()
    {
        return $this->_getApi()->ping();
    }


    /**
     * @return Storm_ElasticSearch_Model_Api
     */
    protected function _getApi()
    {
        return $this->_api;
    }
}
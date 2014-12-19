<?php
class Storm_ElasticSearch_Helper_Config extends Mage_Core_Helper_Abstract
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return array(
            'host' => $this->getAddress()
        );
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return sprintf('http://%s:%s',
            Mage::getStoreConfig('catalog/search/host'),
            Mage::getStoreConfig('catalog/search/port')
        );
    }
}
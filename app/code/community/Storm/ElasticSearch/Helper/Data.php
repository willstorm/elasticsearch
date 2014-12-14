<?php
class Storm_ElasticSearch_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * @param string $message
     * @return Storm_ElasticSearch_Helper_Data
     */
    public function log($message)
    {
        Mage::log($message, 'elasticsearch.log', true);
        return $this;
    }
}
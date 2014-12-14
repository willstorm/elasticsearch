<?php
class Storm_ElasticSearch_Helper_Config extends Mage_Core_Helper_Abstract
{
    /**
     * @return array
     */
    public function getConfig()
    {
        // @TODO mudar as configurações para serem feitas através do aadmin
        return array(
            'host' => 'http://localhost:9200'
        );
    }
}
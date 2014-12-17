<?php
class Storm_ElasticSearch_Model_Engine
{
    const SEARCH_TYPE_ELASTICSEARCH = 4;

    protected $_api;

    public function __construct()
    {
        $this->_api = Mage::getModel('elasticsearch/api');
        return $this;
    }
}
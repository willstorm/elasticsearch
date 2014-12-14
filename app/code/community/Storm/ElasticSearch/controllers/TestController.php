<?php
class Storm_ElasticSearch_TestController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        /** @var Storm_ElasticSearch_Model_Api $api */
        $api = Mage::getModel('elasticsearch/api');
        var_dump($api->ping());
        die;
    }
}
<?php
class Storm_ElasticSearch_TestController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        /** @var Storm_ElasticSearch_Model_Api $api */
        $api = Mage::getModel('elasticsearch/api');
        $api->delete();
        $items = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('name');
        foreach($items as $item) {
            var_dump($api->add('product', array(
                'id' => $item->getId(),
                'name' => $item->getName()
            )));
            echo $item->getName();
        }
    }
}
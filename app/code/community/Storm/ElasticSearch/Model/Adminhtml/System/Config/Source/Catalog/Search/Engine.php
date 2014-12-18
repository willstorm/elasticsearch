<?php
class Storm_ElasticSearch_Model_Adminhtml_System_Config_Source_Catalog_Search_Engine
{
    const ENGINE_FULLTEXT      = 'catalogsearch/fulltext_engine';
    const ENGINE_ELASTICSEARCH = 'elasticsearch/engine';

    public function toOptionArray()
    {
        $types = array(
            self::ENGINE_FULLTEXT => 'Fulltext',
            self::ENGINE_ELASTICSEARCH => 'ElasticSearch',
        );
        $options = array();
        foreach ($types as $k => $v) {
            $options[] = array(
                'value' => $k,
                'label' => $v
            );
        }
        return $options;
    }
}

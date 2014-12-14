<?php
class Storm_ElasticSearch_Model_Api
{
    const INDEX         = 'magento';

    const TYPE_PRODUCT  = 'product';
    const TYPE_CATEGORY = 'category';
    const TYPE_PAGE     = 'page';

    protected $_config;

    /**
     * Start script to get configs
     */
    public function __construct()
    {
        $this->_config = Mage::helper('elasticsearch/config')->getConfig();
        return $this;
    }

    /**
     * Add a document
     *
     * @param string $type
     * @param array $data
     * @return array
     */
    public function add($type, array $data)
    {
        if(!isset($data['id'])) {
            throw new Exception('An id must be specified.');
        }

        $url = $this->_getBaseRequestUrl(array(
            'type' => $type,
            'id'   => $data['id']
        ));

        if($result = $this->request($url, $data)) {
            return (bool) $result['created'];
        }

        return false;
    }

    /**
     * Get a document
     *
     * @param null $type
     * @param null $id
     * @return array
     */
    public function get($type = null, $id = null)
    {
        $url = $this->_getBaseRequestUrl(array(
            'type' => $type,
            'id'   => $id
        ));

        return $this->request($url, array(), Zend_Http_Client::GET);
    }

    /**
     * Delete a document
     *
     * @param null|string $type
     * @param null|int $id
     * @return array
     */
    public function delete($type = null, $id = null)
    {
        $url = $this->_getBaseRequestUrl(array(
            'type' => $type,
            'id'   => $id
        ));

        if($result = $this->request($url, array(), Zend_Http_Client::DELETE)) {
            return $result['found'];
        }

        return false;
    }

    /**
     * Test connection to server
     *
     * @return bool
     */
    public function ping()
    {
        $result = $this->request('', array('_index' => false), Zend_Http_Client::GET);

        if(isset($result['status']) && $result['status'] == 200) {
            return true;
        }

        return false;
    }

    /**
     * Perform a request to elastic search server
     *
     * @param string $url
     * @param array $params
     * @param string $method
     * @return array
     */
    public function request($url = null, $params = array(), $method = Zend_Http_Client::POST)
    {
        try {
            $url = $this->_getBaseRequestUrl(array(
                'host'  => $this->_config['host'],
                'index' => $params['_index'] !== false ? self::INDEX : null,
                'url'   => $url
            ));

            $client = new Zend_Http_Client($url);
            $client->setMethod($method)
                   ->setRawData(Zend_Json::encode($params), 'application/json');

            if(!$response = $client->request()->getBody()) {
                throw new Exception('');
            }

            return Zend_Json::decode($response);
        } catch(Exception $e) {

            return false;
        }
    }

    /**
     * Mount an url
     *
     * @param array $params
     * @return string
     */
    protected function _getBaseRequestUrl($params = array())
    {
        if(!is_array($params)) {
            $params = array($params);
        }

        $url = '';
        foreach($params as $param) {
            if(empty($param)) {
                continue;
            }

            $url .= $param;
            if(++$i != count($params)) {
                $url .= '/';
            }
        }

        return $url;
    }
}
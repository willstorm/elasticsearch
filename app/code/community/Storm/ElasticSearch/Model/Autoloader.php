<?php
class Storm_ElasticSearch_Model_Autoloader
{
    protected $_registered = false;

    /**
     * @param Varien_Event_Observer $observer
     * @return Storm_ElasticSearch_Model_Autoloader
     */
    public function addAutoloader(Varien_Event_Observer $observer)
    {
        if (!$this->_registered) {
            spl_autoload_register(array($this, 'autoload'), false, true);
            $this->_registered = true;
        }

        return $this;
    }

    /**
     * @param string $class
     * @return Storm_ElasticSearch_Model_Autoloader
     */
    public function autoload($class)
    {
        $file = str_replace('\\', '/', $class) . '.php';

        if (strpos($file, '/')) {
            require_once $file;
        }

        return $this;
    }
}
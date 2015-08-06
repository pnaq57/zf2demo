<?php
namespace Application\Entity;

/**
 * Description of EntityAbstract
 *
 * @author aqnguyen
 */
abstract class EntityAbstract
{
    protected $rawData;


    public function setRawData(array $data)
    {
        if (!count($data)) {
            return;
        }
        $this->rawData = $data;
        foreach ($data as $key => $value) {
            $columns = $this->getColumns();
            if (in_array($key, $columns)) {
                $method = \Application\Service\Utils\StringHandler::dashesToCamelCase($key);
                $method = 'set' . ucfirst($method);
                $value = \Application\Service\Utils\StringHandler::filterUmlauts($value);
                $this->$method($value);
            }            
        }
    }
    
    public function __call($method, $arguments)
    {
        if (method_exists($this, $method)) {
            if (!empty($arguments)) {
                foreach ($arguments as &$arg) {
                    $arg = \Application\Service\Utils\StringHandler::filterUmlauts($arg);
                }
            }
            return call_user_func_array(array($this, $method), $arguments);
        }
    }

    
    abstract public function getColumns();
    
    public function getRawData()
    {
        return $this->rawData;
    }
    
}
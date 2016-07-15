<?php
namespace Users\Service;
use Zend\View\Model\ViewModel;
use Users\Model\VitalrecordsTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Debug\Debug;
use Zend\Session\Container;
use Zend\Db\Adapter\Adapter;
use Zend\Validator\Db\RecordExists;

class VitalrecordsService
{    
    public function __construct(Adapter $adapter) {
      $this->adapter = $adapter;
    }

    //function for vital records has been created on 11/02/15
    
    public function vitalrecords($action, $data)
    {
		$vitalrecordsTable = new VitalrecordsTable($this->adapter);
		
		if($action == "getVitalrecords")
		$res = $vitalrecordsTable->getVitalrecords($data);	
		
		if($action == "createvitalrecords")
		$res = $vitalrecordsTable->createVitalrecord($data);
		
		
        return $res;
    }
   
    
    
}

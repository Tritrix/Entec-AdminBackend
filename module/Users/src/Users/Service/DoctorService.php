<?php
namespace Users\Service;
use Zend\View\Model\ViewModel;
use Users\Model\DoctorTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Debug\Debug;
use Zend\Session\Container;
use Zend\Db\Adapter\Adapter;

use Zend\Validator\Db\RecordExists;

use Zend\Cache\StorageFactory;

class DoctorService
{    
    public function __construct(Adapter $adapter) {
      $this->adapter = $adapter;
    }
 
    public function finddoctor()
    {
		$doctorTable = new DoctorTable($this->adapter);
		$res = $doctorTable->finddoctor();	
        return $res;
    }

}

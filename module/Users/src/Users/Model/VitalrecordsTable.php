<?php
namespace Users\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;

use Zend\View\Model\ViewModel;
use Register\Form\RegisterForm;

use Zend\Db\Sql\Sql;

use Zend\Debug\Debug;
use Zend\Db\Sql\Select;

class VitalrecordsTable extends AbstractTableGateway
{
    
   protected $table ='users';
  
   //public $doctor_id;
	
	 public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
	
	
    
    
     public function getVitalrecords($data)
    {
        $sql = "SELECT * FROM `vitalrecords` WHERE user_id = '".$data->user_id."'";		
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( (1)) {
               $resp = $rows;
        }
        return $resp;
    }
    
    
    
}
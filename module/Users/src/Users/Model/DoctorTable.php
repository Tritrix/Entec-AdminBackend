<?php
namespace Users\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Debug\Debug;

class DoctorTable extends AbstractTableGateway
{
    
   protected $table ='users';
   public $id;
   //public $doctor_id;
	
	 public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
	
	
    
    
    
     //GET Doctors (ALL DOC)
     public function finddoctor()
    {
        // echo " doc get all table"; exit;
        $sql = "SELECT b.user_id,b.user_first_name,b.user_last_name FROM doctors a LEFT JOIN users b ON a.users_user_id = b.user_id";	
             
             //$sql = "SELECT b.user_id,b.user_first_name,b.user_last_name FROM doctors a LEFT JOIN users b ON a.users_user_id = b.user_id LEFT JOIN users b ON a.users_user_id = b.user_id";	
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
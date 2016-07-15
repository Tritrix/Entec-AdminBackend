<?php
namespace Users\Model;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Debug\Debug;

class AppointmentsTable extends AbstractTableGateway
{
    
   protected $table ='users';
   public $id;
   //public $doctor_id;
	
	 public function __construct(Adapter $adapter) {
       
      $this->adapter = $adapter;
      $this->initialize();
    }
    
    
     //GET APPOINTMENTS LIST (ALL APTS)
     public function getList( $data )
    {
        $sql = "SELECT * FROM `appointments` WHERE apt_pat_id = '".$data->patID."'";	
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( (1)) {
               $resp = $rows;
        }
        
        return $resp;
    }
    
    //GET APPOINTMENT
    public function get( $data )
    {
        $sql = "SELECT * FROM `appointments` WHERE apt_id = '".$data->aptID."' LIMIT 0,1";	
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( ($result->count() === 1 )) {
          
        $resp = array( 
            'apt_id' => $rows[0]['apt_id'], 
            'pat_id' => $rows[0]['apt_pat_id'], 
            'doc_id' => $rows[0]['apt_doc_id'], 
            'apt_time' => $rows[0]['apt_time'], 
            'apt_subject' => $rows[0]['apt_subject'], 
            'apt_desc' => $rows[0]['apt_desc']
        );
          
        }
        return $resp;
    }
    
    
    //CREATE APPOINTMENT
    public function create( $data )
    {
        
        $response = array();
        try {
            $tableName = "appointments";
            $sql = "INSERT INTO `{$tableName}` (
            `apt_pat_id`,
            `apt_doc_id`,
            `apt_time`,
            `apt_subject`,
            `apt_desc`,
            `apt_created_date`
            ) VALUES (
            '".$data->patID."', 
            '".$data->docID."',
            '".$data->aptTime."',
            '".$data->aptSubject."',
            '".$data->aptDesc."',
            now()
            )";
            
            $statement  = $this->adapter->query($sql);
            $result =  $statement->execute();
            if ( ($result->count() === 1 )) {
                
                $aptID = $this->adapter->getDriver()->getLastGeneratedValue();
                $sqlGet = "SELECT * FROM `{$tableName}` WHERE apt_id = '".$aptID."' LIMIT 0,1";
                $statementGet  = $this->adapter->query($sqlGet);
                $resultGet =  $statementGet->execute();
                $rows = array_values(iterator_to_array($resultGet));
                $response = array( 
                    'apt_id' => $rows[0]['apt_id'], 
                    'pat_id' => $rows[0]['apt_pat_id'], 
                    'doc_id' => $rows[0]['apt_doc_id'], 
                    'apt_time' => $rows[0]['apt_time'], 
                    'apt_subject' => $rows[0]['apt_subject'], 
                    'apt_created_date' => $rows[0]['apt_created_date']
                );
                
            }
        } catch(\Exception $e) {
            $msg = $e->getMessage();
            if(strpos($msg, "1062") !== false) {
              $response = array('errorCode' => 536 );
            }
        }
       return $response;
    }
    
    
    
    //DELETE APPOINTMENT
    public function delete( $data )
    {
        
        $response = array();
        try {
            $tableName = "appointments";
            $sql = "DELETE FROM `{$tableName}` WHERE `apt_id` = '".$data->aptID."'";
            $statement  = $this->adapter->query($sql);
            $result =  $statement->execute();
            if ( ($result->count() === 1 )) {
                $response = array('apt_id' => $data->aptID);   
            }
        } catch(\Exception $e) {
            $msg = $e->getMessage();
            if(strpos($msg, "1062") !== false) {
              $response = array('errorCode' => 552); //Problem in deleting the appointment
            }
        }
       return $response;
    }
    
    
    
    
    
    
   
    
    
    
}
<?php
namespace Users\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Debug\Debug;

class MessageTable extends AbstractTableGateway
{
    
   protected $table ='users';
   public $id;
   //public $doctor_id;
	
	 public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
	
    
    public function message($data)
    {
        // print_r($data); exit;
        $response = array();
        try {
            $tableName = "messages";
            $sql = "INSERT INTO `{$tableName}` (
            `msg_sent_to_id`,
            `msg_sent_by_id`,
            `msg_subject`,
            `msg_message`,
            `msg_sent_on`,
            `sender_identity`
            ) VALUES (
            '".$data->msg_to."', 
            '".$data->msg_by."',
            '".$data->subject."',
            '".$data->message."',
            now(),
            '".$data->sender_identity."'
            )";
            
           // echo $sql; exit;
            $statement  = $this->adapter->query($sql);
            $result =  $statement->execute();
            //if ( ($result->count() === 1 )) {
               
                
            //$apt_id = $this->adapter->getDriver()->getLastGeneratedValue();
                
            // $sqlGet = "SELECT * FROM `{$tableName}` WHERE apt_id = '".$apt_id."' LIMIT 0,1";
            //$statementGet  = $this->adapter->query($sqlGet);
            //$resultGet =  $statementGet->execute();
            //$rows = array_values(iterator_to_array($resultGet));
            //$response = array('apt_id' => $rows[0]['pat_id'], 'doc_id' => $rows[0]['doc_id'], 'apt_time' => $rows[0]['apt_time'], 'apt_subject' => $rows[0]['apt_subject'], 'apt_created_date' => $rows[0]['apt_created_date']);   
            //}
        } catch(\Exception $e) {
           $msg = $e->getMessage();
              $response = array('status' => $msg );
        }
       return $response;
    }
    
   
    
    
     //GET message for inbox
     public function inbox($id)
    {
        //echo "table inbox".$id; exit;
        $sql = "SELECT a.*,b.user_first_name,b.user_last_name FROM messages a JOIN users b ON a.msg_sent_to_id = b.user_id WHERE msg_sent_to_id = '".$id."' and is_archive = 'NO' and is_deleted = 'NO'";
        // echo $sql; exit;
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( ($result->count() === 1 )) {
          
                //$resp = array( 'apt_id' => $rows[0]['apt_id'], 'pat_id' => $rows[0]['pat_id'], 'doc_id' => $rows[0]['doc_id'], 'apt_time' => $rows[0]['apt_time'], 'apt_subject' => $rows[0]['apt_subject'], 'apt_desc' => $rows[0]['apt_desc']);
          
        }
        return $rows;
    }
    
    
    //POST message for move inbox to archive
     public function inboxtoarchive($id,$message_id)
    {
        //echo "table inbox".$message_id; exit;
         $sql = "UPDATE messages SET is_archive = 'YES' where msg_sent_to_id = ".$id." and msg_id in (".$message_id.")";
         
           //echo $sql; exit;
        $response = array();
          try
                {
                    $statement  = $this->adapter->query($sql);
                    $res =  $statement->execute();
                   // $response = array('status' => 'success');
                } catch(\Exception $e) {
                    $msg = $e->getMessage();
                    if(strpos($msg, "1064") !== false) {
                      $response = array('status' => 'error');
                    }
                }
       
        return $response;
    }
    
    
    
    //GET message for sent items
     public function outbox($id)
    {
        //echo "table outbox".$id; exit;
        $sql = "SELECT a.*,b.user_first_name,b.user_last_name FROM messages a JOIN users b ON a.msg_sent_by_id = b.user_id WHERE msg_sent_by_id = '".$id."' and is_deleted = 'NO'";
        // echo $sql; exit;
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( ($result->count() === 1 )) {
          
                //$resp = array( 'apt_id' => $rows[0]['apt_id'], 'pat_id' => $rows[0]['pat_id'], 'doc_id' => $rows[0]['doc_id'], 'apt_time' => $rows[0]['apt_time'], 'apt_subject' => $rows[0]['apt_subject'], 'apt_desc' => $rows[0]['apt_desc']);
          
        }
        return $rows;
    }
    
    
    //GET message for inbox
     public function archive($id)
    {
        //echo "table archive".$id; exit;
        $sql = "SELECT a.*,b.user_first_name,b.user_last_name FROM messages a JOIN users b ON a.msg_sent_to_id = b.user_id WHERE msg_sent_to_id = '".$id."' and is_archive = 'YES' and is_deleted = 'NO'";
        // echo $sql; exit;
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( ($result->count() === 1 )) {
          
                //$resp = array( 'apt_id' => $rows[0]['apt_id'], 'pat_id' => $rows[0]['pat_id'], 'doc_id' => $rows[0]['doc_id'], 'apt_time' => $rows[0]['apt_time'], 'apt_subject' => $rows[0]['apt_subject'], 'apt_desc' => $rows[0]['apt_desc']);
          
        }
        return $rows;
    }
    
    
    
    
     //POST message for move archive to inbox
     public function archivetoinbox($id,$message_id)
    {
        // echo "table archive".$message_id; exit;
         $sql = "UPDATE messages SET is_archive = 'NO' where msg_sent_to_id = ".$id." and msg_id in (".$message_id.")";
         
         //echo $sql; exit;
        $response = array();
          try
                {
                    $statement  = $this->adapter->query($sql);
                    $res =  $statement->execute();
                   // $response = array('status' => 'success');
                } catch(\Exception $e) {
                    $msg = $e->getMessage();
                    if(strpos($msg, "1064") !== false) {
                      $response = array('status' => 'error');
                    }
                }
       
        return $response;
    }
    
    
    
    
    
    //POST DELETE
     public function deletemessage($id,$message_id)
    {
        //echo "table archive"; exit;
         $sql = "UPDATE messages SET is_deleted = case WHEN is_deleted = 'NO' then 'YES' WHEN is_deleted = 'YES' then 'PER' END where msg_sent_to_id = ".$id." and msg_id in (".$message_id.")";
          //update `test`  set statusflag = 	 case 	 WHEN statusflag = 0 then  1	 WHEN statusflag = 1 then  2	 END	 WHERE id  in (1, 2,3,4);
         echo $sql; exit;
        $response = array();
          try
                {
                    $statement  = $this->adapter->query($sql);
                    $res =  $statement->execute();
                   // $response = array('status' => 'success');
                } catch(\Exception $e) {
                    $msg = $e->getMessage();
                    if(strpos($msg, "1064") !== false) {
                      $response = array('status' => 'error');
                    }
                }
       
        return $response;
    }
    
     //GET all delete messages
     public function listdelete($id)
    {
        //echo "table inbox".$id; exit;
        $sql = "SELECT a.*,b.user_first_name,b.user_last_name FROM messages a JOIN users b ON a.msg_sent_to_id = b.user_id WHERE msg_sent_to_id = '".$id."' and is_archive = 'NO' and is_deleted = 'YES'";
         echo $sql; exit;
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( ($result->count() === 1 )) {
          
                //$resp = array( 'apt_id' => $rows[0]['apt_id'], 'pat_id' => $rows[0]['pat_id'], 'doc_id' => $rows[0]['doc_id'], 'apt_time' => $rows[0]['apt_time'], 'apt_subject' => $rows[0]['apt_subject'], 'apt_desc' => $rows[0]['apt_desc']);
          
        }
        return $rows;
    }
    
}
<?php
namespace Users\Service;
use Zend\View\Model\ViewModel;
use Users\Model\MessageTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Debug\Debug;
use Zend\Session\Container;
use Zend\Db\Adapter\Adapter;

use Zend\Validator\Db\RecordExists;

use Zend\Cache\StorageFactory;

class MessageService
{    
    public function __construct(Adapter $adapter) {
      $this->adapter = $adapter;
    }
   
    
    public function message($data)
    {
		$messageTable = new MessageTable($this->adapter);
		$res = $messageTable->message($data);	
        return $res;
    }
    
    
    public function inbox($id)
    {
		$messageTable = new MessageTable($this->adapter);
		$res = $messageTable->inbox($id);	
        return $res;
    }
    
    
    public function outbox($id)
    {
		$messageTable = new MessageTable($this->adapter);
		$res = $messageTable->outbox($id);	
        return $res;
    }
    
    public function inboxtoarchive($id,$message_id)
    {
		$messageTable = new MessageTable($this->adapter);
		$res = $messageTable->inboxtoarchive($id,$message_id);	
        return $res;
    }
    
     public function archive($id)
    {
		$messageTable = new MessageTable($this->adapter);
		$res = $messageTable->archive($id);	
        return $res;
    }

    public function archivetoinbox($id,$message_id)
    {
		$messageTable = new MessageTable($this->adapter);
		$res = $messageTable->archivetoinbox($id,$message_id);	
        return $res;
    }
    
    public function delete($id,$message_id)
    {
		$messageTable = new MessageTable($this->adapter);
		$res = $messageTable->deletemessage($id,$message_id);	
        return $res;
    }
    
    public function listdelete($id)
    {
		$messageTable = new MessageTable($this->adapter);
		$res = $messageTable->listdelete($id);	
        return $res;
        
        
    }
    

}

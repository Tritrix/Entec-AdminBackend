<?php

namespace Register\Service;


use Zend\View\Model\ViewModel;
use Register\Model\RegisterTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Debug\Debug;
use Zend\Session\Container;
use Zend\Db\Adapter\Adapter;


 


use Zend\Validator\Db\RecordExists;


class RegisterService
{    
    public function __construct(Adapter $adapter) {
      $this->adapter = $adapter;
    }

    
    public function adminlogin($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->adminlogin($data);	
        return $res;
    }
    
     public function addclient($data,$logoPath)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->addclient($data,$logoPath);	
        return $res;
    }
    
     public function listclient($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->listclient($data);	
        return $res;
    }
      public function editclient($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->editclient($data);	
        return $res;
    }
     public function updateclient($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->updateclient($data);	
        return $res;
    }
	
    public function deleteclient($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->deleteclient($data);	
        return $res;
    }
     
    public function adduser($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->adduser($data);	
        return $res;
    }
     public function listuser($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->listuser($data);	
        return $res;
    }
     public function edituser($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->edituser($data);	
        return $res;
    }
     public function updateuser($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->updateuser($data);	
        return $res;
    }
    
      public function deleteuser($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->deleteuser($data);	
        return $res;
    }
    
      public function addaudit($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->addaudit($data);	
        return $res;
    }
    
      public function editaudit($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->editaudit($data);	
        return $res;
    }
    
    public function deleteaudit($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->deleteaudit($data);	
        return $res;
    }
    
     public function listaudit($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->listaudit($data);	
        return $res;
    }
    
      public function listclientaudit($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->listclientaudit($data);	
        return $res;
    }
    
    
      public function addobservation($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->addobservation($data);	
        return $res;
    }
    
      public function updateobservation($data)
    {
 		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->updateobservation($data);	
        return $res;
    }
    
    
      public function listobservation($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->listobservation($data);	
        return $res;
    }
    
      public function logoutadmin($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->logoutadmin($data);	
        return $res;
    }
      public function changepassword($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->changepassword($data);	
        return $res;
    }
    
     public function notificationsettings($data)
    {
		$registerTable = new RegisterTable($this->adapter);
		$res = $registerTable->notificationsettings($data);	
        return $res;
    }
    
    
    
    
}

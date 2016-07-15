<?php
namespace Users\Service;
use Zend\View\Model\ViewModel;
use Users\Model\UsersTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Debug\Debug;
use Zend\Session\Container;
use Zend\Db\Adapter\Adapter;

use Zend\Validator\Db\RecordExists;

use Zend\Cache\StorageFactory;

class UsersService
{    
    public function __construct(Adapter $adapter) {
      $this->adapter = $adapter;
    }
 
    public function update($data,$id)
    {
		$usersTable = new UsersTable($this->adapter);
		$res = $usersTable->updateProfile($data,$id);	
        return $res;
    }
	
    public function get($data)
    {

		$usersTable = new UsersTable($this->adapter);
		$res = $usersTable->get($data);	
        return $res;
    }
	

	public function doctorprofile($data,$id)
    {
		$usersTable = new UsersTable($this->adapter);
		$res = $usersTable->updatedoctorProfile($data,$id);	
        return $res;
    }
    
    
    public function state()
    {
		$usersTable = new UsersTable($this->adapter);
		$res = $usersTable->state();	
        return $res;
    }
    
    public function city($id)
    {
		$usersTable = new UsersTable($this->adapter);
		$res = $usersTable->city($id);	
        return $res;
    }

    
     public function country($id)
    {
		$usersTable = new UsersTable($this->adapter);
		$res = $usersTable->country($id);	
        return $res;
    }
   

}

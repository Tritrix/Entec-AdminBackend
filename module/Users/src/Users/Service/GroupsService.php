<?php
namespace Users\Service;

use Users\Model\GroupsTable;
use Zend\Db\Adapter\Adapter;

class GroupsService
{    

    public function __construct(Adapter $adapter) {
      $this->adapter = $adapter;
    }

    public function getList( $data ) {
      $groupsTable = new GroupsTable( $this->adapter ); 
      $res = $groupsTable->getList( $data );
      return $res;
    }
    
    
    public function get( $data ) {
      $appointmentsTable = new AppointmentsTable( $this->adapter ); 
      $res = $appointmentsTable->get( $data );
      return $res;
    }
    
    public function create($data,$userID) {
      $groupsTable = new GroupsTable( $this->adapter ); 
      $res = $groupsTable->create($data,$userID);
      return $res;
    }
    
    public function update($data) {
      $groupsTable = new GroupsTable( $this->adapter ); 
      $res = $groupsTable->update_group($data);
      return $res;
    }
    
    public function delete( $data ) {
      $groupsTable = new GroupsTable( $this->adapter ); 
      $res = $groupsTable->delete_group( $data );
      return $res;
    }
    
}

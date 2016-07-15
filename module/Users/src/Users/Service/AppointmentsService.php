<?php
namespace Users\Service;

use Users\Model\AppointmentsTable;
use Zend\Db\Adapter\Adapter;

class AppointmentsService
{    

    public function __construct(Adapter $adapter) {
      $this->adapter = $adapter;
    }

    public function getList( $data ) {
      $appointmentsTable = new AppointmentsTable( $this->adapter ); 
      $res = $appointmentsTable->getList( $data );
      return $res;
    }
    
    
    public function get( $data ) {
      $appointmentsTable = new AppointmentsTable( $this->adapter ); 
      $res = $appointmentsTable->get( $data );
      return $res;
    }
    
    public function create( $data ) {
      $appointmentsTable = new AppointmentsTable( $this->adapter ); 
      $res = $appointmentsTable->create( $data );
      return $res;
    }
    
    public function delete( $data ) {
      $appointmentsTable = new AppointmentsTable( $this->adapter ); 
      $res = $appointmentsTable->delete( $data );
      return $res;
    }
    
}

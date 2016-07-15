<?php
namespace Users\Model;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Debug\Debug;

class GroupsTable extends AbstractTableGateway
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
        $sql = "SELECT * FROM `groups` WHERE grp_id = '".$data->userID."'";	
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows_master = array_values(iterator_to_array($result));
       
         
        $sql_profile = "SELECT * FROM `group_profile` WHERE grp_id = '".$data->userID."'";	
        $statement_profile  = $this->adapter->query($sql_profile);
        $result_profile =  $statement_profile->execute();
        $rows_profile = array_values(iterator_to_array($result_profile));
         
        $rows = array_merge($rows_master, $rows_profile);
        //$rows_master->merge($rows_profile);
        //$rows = $rows_profile + $rows_master;
        //print_r($rows); exit;
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
          
        $resp = array( 'apt_id' => $rows[0]['apt_id'], 'pat_id' => $rows[0]['pat_id'], 'doc_id' => $rows[0]['doc_id'], 'apt_time' => $rows[0]['apt_time'], 'apt_subject' => $rows[0]['apt_subject'], 'apt_desc' => $rows[0]['apt_desc']);
          
        }
        return $resp;
    }
    
    
    //CREATE APPOINTMENT
    public function create($data,$userID)
    {
        //print_r($data); exit;
        
        $response = array();
        try {
            
            //groups master insert
            
             // START :: SQL :: INSERT INTO GROUP PROFILE //
            
            $tableName = "groups";
            $sql = "INSERT INTO `{$tableName}` (
            `grp_name`,
            `grp_type_id`,
            `users_user_id`,
            `grp_created`,
            `grp_is_inactive`
            ) VALUES (
            '".$data->group_name."', 
            '".$data->group_type."',
            '".$userID."',
            now(),
            '1'
            )";
            
            $statement  = $this->adapter->query($sql);
            $result =  $statement->execute();
            
            
            //groups details insert
            
            $lastGroupID = $this->adapter->getDriver()->getLastGeneratedValue();
            
                
            $tableNameGroupProfile = "group_profile";
                
            //$tableNameProfile = "users_groups";
                
            $sqlGroupProfile = "INSERT INTO `{$tableNameGroupProfile}` (
            `grp_id`,
            `grp_description`,
            `grp_address1`,
            `grp_address2`,
            `grp_country`,
            `grp_state`,
            `grp_city`,
            `grp_postal_code`,
            `grp_landmark`,
            `grp_lat`,
            `grp_lng`,
            `grp_phone1`,
            `grp_mobile1`,
            `grp_phone2`,
            `grp_mobile2`,
            `grp_services_offered`,
            `grp_created`
            ) VALUES (
            '".$lastGroupID."',
            '".$data->group_description."',
            '".$data->address1."',
            '".$data->address2."',
            '".$data->country."',
            '".$data->state."',
            '".$data->city."',
            '".$data->postal_code."',
            '".$data->landmark."',
            '".$data->lat."',
            '".$data->lng."',
            '".$data->phone1."',
            '".$data->mobile1."',
            '".$data->phone2."',
            '".$data->mobile2."',
            '".$data->servicesoffered."',
            now()
            )";
                
            // echo   $sqlGroupProfile; exit;  
            // END :: SQL :: INSERT INTO GROUP PROFILE //    
            
            $statement_group_profile  = $this->adapter->query($sqlGroupProfile);
            $result_group_profile =  $statement_group_profile->execute();
            
//            if ( ($result->count() === 1 )) {
//                
//           
//            //JOIN THE groups and groups and group_profile tables to get the inserted records
//            $sqlGet = "SELECT * FROM `{$tableName}` WHERE apt_id = '".$lastGroupID."' LIMIT 0,1";
//            $statementGet  = $this->adapter->query($sqlGet);
//            $resultGet =  $statementGet->execute();
//            $rows = array_values(iterator_to_array($resultGet));
//            $response = array('apt_id' => $rows[0]['pat_id'], 'doc_id' => $rows[0]['doc_id'], 'apt_time' => $rows[0]['apt_time'], 'apt_subject' => $rows[0]['apt_subject'], 'apt_created_date' => $rows[0]['apt_created_date']);   
//            }
            
            
           $response = array('status' => 'success' );
            
        } catch(\Exception $e) {
            $msg = $e->getMessage();
            if(strpos($msg, "1062") !== false) {
              $response = array('errorCode' => 802 );
            }
           
        }
        print_r($response); exit;
       return $response;
    }
    
    public function update_group($data)
    {
             
        $tableName = "groups";
        $sql = "UPDATE `{$tableName}` SET
        `grp_name` = '".$data['group_name']."'
        where grp_id ='".$data['grpID']."';";


        $statement  = $this->adapter->query($sql);
        $res =  $statement->execute();
		
        if ( ($res->count() === 1 )) {
            $response = array('status' => 'success');
        }
        else
        {
            $response = array('errorCode' => 803,'status' => 'user id does not exist');
        }
       
        
        $tableName = "group_profile";
        $group_profile = "UPDATE `{$tableName}` SET
        `grp_description` = '".$data['group_description']."',
        `grp_address1` = '".$data['address1']."',
        `grp_address2` = '".$data['address2']."',
        `grp_city` = '".$data['city']."',
        `grp_country` = '".$data['country']."',
        `grp_state` = '".$data['state']."',
        `grp_postal_code` = '".$data['postal_code']."',
        `grp_landmark` = '".$data['landmark']."',
        `grp_phone1` = '".$data['phone1']."',
        `grp_mobile1` = '".$data['mobile1']."',
        `grp_phone2` = '".$data['phone2']."',
        `grp_phone2` = '".$data['mobile2']."',
        `grp_lat` = '".$data['lat']."',
        `grp_lng` = '".$data['lng']."',
        `grp_founded` = '".$data['founded']."',
        `grp_services_offered` = '".$data['servicesoffered']."'
        where grp_id ='".$data['grpID']."';";

        
        $statement  = $this->adapter->query($group_profile);
        $res_group =  $statement->execute();
		
        if ( ($res_group->count() === 1 )) {
            $response = array('status' => 'success');
        }
        else
        {
            $response = array('errorCode' => 803,'status' => 'user does not exist in group profile');
        }
        
			  

        return $response;
        
    }
    
    
    
    //DELETE APPOINTMENT
    public function delete_group( $data )
    {
        
        $response = array();
        

        $tableName = "groups";
        $sql = "UPDATE `{$tableName}` SET
        `grp_is_inactive` = '0'
        where grp_id ='".$data->grpID."';";


        $statement  = $this->adapter->query($sql);
        $res =  $statement->execute();
		
        if ( ($res->count() === 1 )) {
            $response = array('status' => 'success');
        }
        else
        {
            $response = array('errorCode' => 804,'status' => 'user id does not exist');
        }

        
        return $response;
    }
    
    
    
    
    
    
   
    
    
    
}
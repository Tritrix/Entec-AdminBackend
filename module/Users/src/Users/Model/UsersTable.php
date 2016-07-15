<?php
namespace Users\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Debug\Debug;

class UsersTable extends AbstractTableGateway
{
    
   protected $table ='users';
   public $id;
   //public $doctor_id;
	
	 public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
	
	
    
     public function country()
    {
        //echo "state table"; exit;
            
        $sql = "SELECT country_id,country FROM `country`";	
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        
               
       //print_r($rows); exit;
        return $rows;
    }
    
    
    
    public function state()
    {
        //echo "state table"; exit;
            
        $sql = "SELECT state_id,state FROM `state_list`";	
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        
               
       //print_r($rows); exit;
        return $rows;
    }
    
    
    public function city($id)
    {
        //echo "state table".$id; exit;
            
        $sql = "SELECT city_id,city_name FROM `cities` where state_id = '".$id."'";	
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        
               
       //print_r($rows); exit;
        return $rows;
    }
    
    
   
    public function updateProfile($data,$id)
    {
        
            
            $tableName = "users";
            $sql = "UPDATE `{$tableName}` SET
            `user_gender` = '".$data->gender."',
            `user_country` = '".$data->country."',
            `user_state` = '".$data->state."',
            `user_city`= '".$data->city."',
			`user_address1`='".$data->address1."',
			`user_address2`='".$data->address2."',			
			`user_postal_code`='".$data->postal_code."',			
			`user_birthdate`='".$data->birthdate."',									
			`user_phone`='".$data->phone."',
			`user_mobile`='".$data->mobile."',	
			`user_blood_group`='".$data->blood_group."',
            `user_profile_built`='1',
            `user_modified` = now()
             where user_id ='".$id."';";
			 
			 
			  $statement  = $this->adapter->query($sql);
 			  $res =  $statement->execute();
			  //print_r($res); exit;
			  
			
                $response = array();
                try
                {
                    $statement  = $this->adapter->query($sql);
                    $res =  $statement->execute();
                   // $response = array('status' => 'success');
                   
                } catch(\Exception $e) {
                    $msg = $e->getMessage();
                    if(strpos($msg, "1062") !== false) {
                      $response = array('errorCode' => 600);
                    }
                }

        return $response;
    }
	
    
    public function get($data)
    {
        //$sql = "SELECT * FROM `users` WHERE user_id = '".$data->id."' LIMIT 0,1";	
        $sql = "SELECT * FROM users a LEFT JOIN state_list b ON a.user_state = b.state_id LEFT JOIN cities c ON a.user_city = c.city_id LEFT JOIN country d ON a.user_country = d.country_id WHERE user_id = '".$data->id."'";
        //echo $sql; exit;    
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( ($result->count() === 1 )) {
            if( $rows[0]['user_is_verified'] == '1') {
                $resp = array('id' => $rows[0]['user_id'], 'email' => $rows[0]['user_email_id'], 'firstName' => $rows[0]['user_first_name'], 'lastName' => $rows[0]['user_last_name'], 'address' => $rows[0]['user_address1'], 'country' => $rows[0]['country'], 'state' => $rows[0]['state'], 'city' => $rows[0]['city_name'], 'postal_code' => $rows[0]['user_postal_code'], 'gender' => $rows[0]['user_gender'], 'birthdate' => $rows[0]['user_birthdate'], 'phone' => $rows[0]['user_phone'], 'mobile' => $rows[0]['user_mobile'], 'blood_group' => $rows[0]['user_blood_group'], 'profile_built' => $rows[0]['user_profile_built'], 'weight' => $rows[0]['user_weight'], 'height' => $rows[0]['user_height'], 'bmi' => $rows[0]['user_bmi']);
            }
            else {
                $resp = array('errorCode' => 523); 
            }
        }
        return $resp;
	}	
	
	
	
	public function updatedoctorProfile($data,$id)
    {
       try {
			$tableName = "doctors";
            $sql = "INSERT INTO `{$tableName}` (
            `doc_med_coun_num`,
            `doc_created`,
            `users_user_id`
            ) VALUES (
            '".$data->council_number."', 
            'now()',
            '".$id."'
            );";
			  $statement  = $this->adapter->query($sql);
 			  $res =  $statement->execute();
			  //print_r($res); exit;
			  $response = array('status' => 'success');
		      return $response;
			  
          } catch(\Exception $e) {
            $msg = $e->getMessage();
            if(strpos($msg, "1062") !== false) {
              $response = array('errorCode' => 520,'status' => 'failure');
            }
        }
       return $response;
    }
	
	
	 public function checkAuth($data)
    {
        $log_email = $data->email;
        $log_password = $data->password;
        $sql = "SELECT * FROM `users` WHERE user_email_id = '".$log_email."' AND user_password = '".md5($log_password)."' LIMIT 0,1";	
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( ($result->count() === 1 )) {
            if( $rows[0]['user_is_verified'] == '1') {
                $resp = array('id' => $rows[0]['user_id'], 'email' => $data->email, 'firstName' => $rows[0]['user_first_name'], 'lastName' => $rows[0]['user_last_name']);
            }
            else {
                $resp = array('errorCode' => 513); 
            }
        }
        return $resp;
    }
    
    
     public function checkVerification($data)
    {
        $user_verification_code = $data->verification_code;
        $user_id = $data->id;
        $sql = "SELECT * FROM `users` WHERE user_id = '".$user_id."' AND user_verification_code = '".$user_verification_code."' LIMIT 0,1";	
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( ($result->count() === 1 )) {
        
            //update the row :: user_is_verified = 1 and verification code empty
            $tableName = "users";
            $sqlUpdate = "UPDATE `{$tableName}` SET 
			`user_is_verified` = 1,
			`user_verification_code` = ''
            WHERE `user_id` = '".$user_id."'";
            $statementUpdate  = $this->adapter->query($sqlUpdate);
            $resUpdate =  $statementUpdate->execute();
            
            $resp = array('id' => $rows[0]['user_id'], 'firstName' => $rows[0]['user_first_name'], 'lastName' => $rows[0]['user_last_name']);
        }
        return $resp;
    }
   
    
    

    //CREATE APPOINTMENT
    public function createAppointment($data)
    {
        
        $response = array();
        try {
            $tableName = "appointments";
            $sql = "INSERT INTO `{$tableName}` (
            `pat_id`,
            `doc_id`,
            `apt_time`,
            `apt_subject`,
            `apt_desc`,
            `apt_created_date`
            ) VALUES (
            '".$data->pat_id."', 
            '".$data->doc_id."',
            '".$data->apt_time."',
            '".$data->apt_subject."',
            '".$data->apt_desc."',
            now()
            )";
            
            $statement  = $this->adapter->query($sql);
            $result =  $statement->execute();
            if ( ($result->count() === 1 )) {
               
                
            $apt_id = $this->adapter->getDriver()->getLastGeneratedValue();
                
             $sqlGet = "SELECT * FROM `{$tableName}` WHERE apt_id = '".$apt_id."' LIMIT 0,1";
            $statementGet  = $this->adapter->query($sqlGet);
            $resultGet =  $statementGet->execute();
            $rows = array_values(iterator_to_array($resultGet));
            $response = array('apt_id' => $rows[0]['pat_id'], 'doc_id' => $rows[0]['doc_id'], 'apt_time' => $rows[0]['apt_time'], 'apt_subject' => $rows[0]['apt_subject'], 'apt_created_date' => $rows[0]['apt_created_date']);   
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
    public function deleteAppointment($data)
    {
        
        $response = array();
        try {
            $tableName = "appointments";
            $sql = "DELETE FROM `{$tableName}` WHERE `apt_id` = '".$data->apt_id."'";
            $statement  = $this->adapter->query($sql);
            $result =  $statement->execute();
            if ( ($result->count() === 1 )) {
                $response = array('apt_id' => $data->apt_id);   
            }
        } catch(\Exception $e) {
            $msg = $e->getMessage();
            if(strpos($msg, "1062") !== false) {
              $response = array('errorCode' => 552); //Problem in deleting the appointment
            }
        }
       return $response;
    }
    
    
    //GET APPOINTMENT
     public function getAppointment($data)
    {
        $sql = "SELECT * FROM `appointments` WHERE apt_id = '".$data->apt_id."' LIMIT 0,1";	
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( ($result->count() === 1 )) {
          
                $resp = array( 'apt_id' => $rows[0]['apt_id'], 'pat_id' => $rows[0]['pat_id'], 'doc_id' => $rows[0]['doc_id'], 'apt_time' => $rows[0]['apt_time'], 'apt_subject' => $rows[0]['apt_subject'], 'apt_desc' => $rows[0]['apt_desc']);
          
        }
        return $resp;
    }
    
    
    
    //GET APPOINTMENTS (ALL APTS)
     public function getAppointments($data)
    {
        $sql = "SELECT * FROM `appointments` WHERE pat_id = '".$data->pat_id."'";	
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ( (1)) {
               $resp = $rows;
        }
        return $resp;
    }
    
    //vital records table has been inserted on 11/02/15
    
     public function vitalrecords($data)
    {
        
        $response = array();
        try {
            $tableName = "vitalrecords";
            $sql = "INSERT INTO `{$tableName}` (
            `user_id`,
            `weight`,
            `height`,
            `bp_high`,
            `bp_low`,
			`sugar_fasting`,
			`sugar_pp`,
			`sugar_random`,
			`hba1c`,
			`systolic`,
			`diastolic`,
			`temperature`,
			`created_date`,
			`modified_date`
            ) VALUES (
            '".$data->user_id."', 
            '".$data->weight."',
            '".$data->height."',
            '".$data->bp_high."',
            '".$data->bp_low."',
			'".$data->sugar_fasting."',
            '".$data->sugar_pp."',
            '".$data->sugar_random."',
            '".$data->hba1c."',
			'".$data->systolic."',
            '".$data->diastolic."',
            '".$data->temperature."',
			now(),
			now()
            )";
			
			
            
            $statement  = $this->adapter->query($sql);
            $result =  $statement->execute();
            if ( ($result->count() === 1 )) {
               
                
            $vital_id = $this->adapter->getDriver()->getLastGeneratedValue();
			
                
            $sqlGet = "SELECT * FROM `{$tableName}` WHERE vital_id = '".$vital_id."' LIMIT 0,1";
			$statementGet  = $this->adapter->query($sqlGet);
            $resultGet =  $statementGet->execute();
            
			$rows = array_values(iterator_to_array($resultGet));
			
           $response = array('user_id' => $rows[0]['user_id'], 'weight' => $rows[0]['weight'], 'height' => $rows[0]['height'], 'bp_high' => $rows[0]['bp_high'], 'bp_low' => $rows[0]['bp_low'],'sugar_fasting' => $rows[0]['sugar_fasting'], 'sugar_pp' => $rows[0]['sugar_pp'], 'sugar_random' => $rows[0]['sugar_random'], 'hba1c' => $rows[0]['hba1c'], 'systolic' => $rows[0]['systolic'],'diastolic' => $rows[0]['diastolic'], 'temperature' => $rows[0]['temperature'], 'created_date' => $rows[0]['created_date'], 'modified_date' => $rows[0]['modified_date']);   

			}
        } catch(\Exception $e) {
            $msg = $e->getMessage();
            if(strpos($msg, "1062") !== false) {
              $response = array('errorCode' => 510);
            }
        }
       return $response;
    }
    
   
    
}
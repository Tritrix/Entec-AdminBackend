<?php
namespace Register\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;

use Zend\View\Model\ViewModel;
use Register\Form\RegisterForm;

use Zend\Db\Sql\Sql;

use Zend\Debug\Debug;
use Zend\Db\Sql\Select;

class RegisterTable extends AbstractTableGateway
{
    
   protected $table ='users';
   public $id;
   //public $doctor_id;
	
	 public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
	
	
   
    public function saveRegister($data)
    {
        
        //echo "goin fine in table"; exit;
        $usertype = $data['who']; 

        //exit;
        // $usertype = ($data['who']!='') ? $data['who'] : 'doctor';	


        // print_r($data);

        // exit;


        $data['created'] = date('Y-m-d H:i:s');
        $data['modified'] = date('Y-m-d H:i:s');
        $activation_code = md5($data['email'].time());


        $tableName1 = "users";
        //$tableName2 = "doctors";

        $sql = "INSERT INTO `{$tableName1}` (
        `user_first_name`,
        `user_last_name`,
        `user_email_id`,
        `user_password`,
        `user_created`,
        `user_modified`,
        `user_verification_code`,
        `user_is_verified`
        ) VALUES (
        '".$data['firstname']."', 
        '".$data['lastname']."',
        '".$data['email']."',
        '".$data['password']."',
        '".$data['created']."',
        '".$data['modified']."',
        '".$activation_code."',
        '0' 
        )";


        //            if($usertype == 'medical_service')
        //            {
        //                
        //                $sql2 = "INSERT INTO `{$tableName2}` (
        //                `doc_created`,
        //                `doc_modified`
        //                ) VALUES (
        //                '".$data['created']."',
        //                '".$data['modified']."' 
        //                )";
        //            }

        //echo $sql; exit;
		
		$statement  = $this->adapter->query($sql);
         
		$res =  $statement->execute();
        
        $lastId = $this->adapter->getDriver()->getLastGeneratedValue();
        
        $table_privacy = "users_privacy_settings";
        //$tableName2 = "doctors";

        $sql_privacy = "INSERT INTO `{$table_privacy}` (
            `u_pri_set_profile_view`,
            `u_pri_set_profile_search`,
            `u_pri_set_connection_request`,
            `user_id`
             ) VALUES (
            'no', 
            'no',
            'no',
            '".$lastId."'
        )";

        $statement_privacy  = $this->adapter->query($sql_privacy);
         
		$res_privacy =  $statement_privacy->execute();
        
		if ( $res->count() === 1 ) {
			
			$resMsg = "sucess";
			$resId = $lastId;
            $email = $data['email'];
            $firstname = $data['firstname'];
            

			$res_return = array(
			'resUsertype' => $usertype,
			'resMsg' => $resMsg,
			'resId' => $resId,
            'email' => $email,
            'firstName' => $firstname,
            'activation_code' => $activation_code,
                
		);
			
			
		} else {
            
            $resMsg = "fail";
            $res_return = array(
            'resMsg' => $resMsg,
            );
            
		}
		
		
		// print_r($res_return); exit;
		return $res_return;
		
    }
	
    
    
    public function checkVerification($data)
    {
        
        $verification = $data['verification'];
        $id = $data['id'];
        
        $sql = "SELECT * FROM `users` WHERE user_id = '".$id."' AND user_verification_code = '".$verification."'";
        
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        
        if ( $result->count() === 1 ) {
            
            $tableName = "users";
            $sql_update = "UPDATE `{$tableName}` SET
            `user_is_verified` = '1',
            `user_modified` = now()
             where user_id ='".$id."';";
            

            $statement_update  = $this->adapter->query($sql_update);
            $res =  $statement_update->execute();
            
            //print_r($res);
            $resMsg = "sucess";
            
			$res_return = array(
			
				'resMsg' => $resMsg,
			
            );
			
        }	else	{
            
            $resMsg = "fail";
            
			$res_return = array(
			
				'resMsg' => $resMsg,
			
            );
            
        }
        
        return $res_return;
        
    }
	
    
    public function forgotPass($data)
    {
        $activation_code = md5($data['resetemail'].time());
         
        
        
         $sql = "SELECT * FROM `users` WHERE user_email_id = '".$data['resetemail']."' ";
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        if ( ($result->count()) == 1 ) {
            
            $tableName = "users";
            $sql_update = "UPDATE `{$tableName}` SET
            `user_verification_code` = '".$activation_code."',
            `user_modified` = now()
            where user_email_id ='".$data['resetemail']."';";

            $statement_update  = $this->adapter->query($sql_update);
            $res =  $statement_update->execute();

            //print_r($res);
            $resMsg = "sucess";
            
        }else{
            
            
             $resMsg = "fail";
            
        }
        
        
         
        
        $res_return = array(
        'resMsg' => $resMsg,
        'resetemail' => $data['resetemail'],
        'activation_code' => $activation_code,
        );
        
        return $res_return;
    }
    
    
    
    
    
    
    public function resetpass($data)
    {
        
        $verification = $data['verification'];
        $email = $data['email'];
        $password = $data['password'];
        
        $sql = "SELECT * FROM `users` WHERE user_email_id = '".$email."' AND user_verification_code = '".$verification."'";
        
        $statement  = $this->adapter->query($sql);
        $result =  $statement->execute();
        
        if ( $result->count() === 1 ) {
            
            $tableName = "users";
            $sql_update = "UPDATE `{$tableName}` SET
            `user_password` = '".$password."',
            `user_modified` = now()
             WHERE user_email_id = '".$email."' AND user_verification_code = '".$verification."';";
            

            $statement_update  = $this->adapter->query($sql_update);
            $res =  $statement_update->execute();
            
            //print_r($res);
            $resMsg = "sucess";
            
			$res_return = array(
			'resMsg' => $resMsg,
            );
        }else{
            
            $resMsg = "fail";
            
			$res_return = array(
			'resMsg' => $resMsg,
            );
            
        }
        
        return $res_return;
        
    }
    
    
    
    
    
	 public function checkAuth($data)
    {
			
		$log_email = $data['log_email'];
		$log_password = $data['log_password'];
		$log_who = $data['log_who'];

		if( $log_who == 'medical_service' )
		{
		//$sql = "SELECT * FROM `users` WHERE user_email_id = '".$log_email."' AND user_password = '".md5($log_password)."' LIMIT 0,1";
            
            
            
            $sql = new Sql($this->adapter);
            $select = $sql->select();
            $select->columns( array('*') );
            $select->from( array('users' => 'users'));


            $select->join(array('groups_employees' => 'groups_employees'), 'users.user_id = groups_employees.usr_id', array(
            'usr_type_id' => 'usr_type_id',
             ), $select::JOIN_LEFT); 
            
            $select->where->equalTo('users.user_email_id', $log_email);
            $select->where->equalTo('users.user_password', md5($log_password));
             
 		}
		else if( $log_who == 'patient' )
		{
		  //$sql = "SELECT * FROM `users` WHERE user_email_id = '".$log_email."' AND user_password = '".md5($log_password)."' LIMIT 0,1";	
            
            
            $sql = new Sql($this->adapter);
            $select = $sql->select();
            $select->columns( array('*') );
            $select->from( array('users' => 'users'));

            $select->where->equalTo('user_email_id', $log_email);
            $select->where->equalTo('user_password', md5($log_password));
		}

        // echo $select->getSqlString($this->adapter->getPlatform());    exit;
        $statement = $sql->prepareStatementForSqlObject($select);
        $result  = $statement->execute();
        $rows = array_values(iterator_to_array($result));

		if (empty($rows)) {
			
			$resMsg = "fail";  

			$res = array(
				'resMsg' => $resMsg,
				'log_who' => $log_who,
			);


		} else {

			if($rows[0]['user_is_verified'] === '1')
			{
                 $resMsg = "sucess";
			}
			else
			{
			$resMsg = "email id is not verified";
			}

			$res = array(
			'resMsg' => $resMsg,
			'log_who' => $log_who,
			'rowset' => $rows[0],
			);

		}
		return $res;
    }
    
    
    
    public function findRowExists($rowArr) 
    {
        
        //echo "already table"; exit;
        
        $log_who = $rowArr['log_who'];
        
        $log_email = $rowArr['log_email'];
         
        // if( $log_who == 'medical_service' )
        // {
            // $sql = "SELECT * FROM `users` WHERE user_email_id = '".$log_email."' LIMIT 0,1";	
        // }
        // else if( $log_who == 'patient' )
        // {
            // $sql = "SELECT * FROM `users` WHERE user_email_id = '".$log_email."' LIMIT 0,1";	
        // }
       
	    $sql = "SELECT * FROM `users` WHERE user_email_id = '".$log_email."' LIMIT 0,1";

        $statement  = $this->adapter->query($sql);
        
        $result =  $statement->execute();
        
        $rows = array_values(iterator_to_array($result));
        
        
        if ( $result->count() === 1 )   {   $resMsg = 1;    }    else    {   $resMsg = 0;    }
		
		$res = array(   'resMsg' => $resMsg,    'log_who' => $log_who   );
        
		return $res;
        
        
    }
	

}
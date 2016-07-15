<?php

namespace Register\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\ViewModel;
use Register\Form\RegisterForm;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Debug\Debug;

class RegisterTable extends AbstractTableGateway {

    protected $table = 'users';
    public $id;

    //public $doctor_id;

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    public function getrandomdoctors($docnum) {

        $num = $docnum['num'];
    }

    public function adminlogin($data) {

        // echo "test"; exit;
        $token = md5($data->username . time());
        //$password =  md5($data->password);
        $password = $data->password;

        $log_username = $data->username;
        $sql = "SELECT * FROM `admin` WHERE username = '" . $log_username . "' and password = '" . $password . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));




        //print_r($rows); exit;
        $resp = array();
        if ($result->count() == 1) {

            $sql_update = "UPDATE `admin` SET token = '" . $token . "' WHERE username = '" . $log_username . "' and password = '" . $password . "';";             // echo $sql; exit;
            $statement_update = $this->adapter->query($sql_update);
            $result = $statement_update->execute();


            $response = array('loginstatus' => 'success', 'errorCode' => 511, 'token' => $token, 'id' => $rows[0]['id'], 'username' => $rows[0]['username']);
            return $response;
        } else {
            $response = array('loginstatus' => 'failure', 'errorCode' => 512, 'errorMessage' => 'Invalid username or password');
            return $response;
        }
    }

    public function addclient($data,$logoPath) {
        $refnumber = md5($data->id . time());
        $refnumber = substr($refnumber, -6);

        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $tableName = "client";
            $sql_addclient = "INSERT INTO `{$tableName}` (
            `client_name`,
            `client_location`,
            `client_address`,
            `client_mobile`,
            `client_landline`,
            `client_email`,
            `client_engagement_type`,
            `client_contact_period_from`,
            `client_contact_period_to`,
            `client_area`,
            `client_city`,
            `client_state`,
            `client_country`,
            `client_pincode`,
            `client_logo`,
            `client_contact_person`,
            `created_date`,
            `created_by`,
            `is_active`
             ) VALUES (
            '" . $data->clientname . "', 
            '" . $data->location . "',
            '" . $data->address . "',
            '" . $data->mobile . "',
            '" . $data->landline . "',
            '" . $data->email . "',
            '" . $data->engagement_type . "',
            '" . $data->contact_period_from . "',
            '" . $data->contact_period_to . "',
            '" . $data->area . "',
            '" . $data->city . "',
            '" . $data->state . "',
            '" . $data->country . "',
            '" . $data->pincode . "',
            '" . $logoPath . "',
            '" . $data->contactperson . "',
            now(),
            '" . $data->id . "',
            '1'
            )";
            
            try {
                $statement = $this->adapter->query($sql_addclient);
                $res = $statement->execute();
                $client_Id = $this->adapter->getDriver()->getLastGeneratedValue();
                $response = array('id' => $data->id, 'clientid' => $client_Id, 'status' => 'success');
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                if (strpos($msg, "1062") !== false) {
                    $response = array('errorCode' => 511, 'errorMsg' => 'sql error');
                }
            }

            return $response;
        } else {


            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function listclient($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $sql_clientlist = "SELECT * FROM `client` WHERE is_active != 0 ORDER BY created_by;";

            // echo $sql_clientlist; exit;
            $statement = $this->adapter->query($sql_clientlist);
            $result = $statement->execute();
            $rows = array_values(iterator_to_array($result));

            $response = array();
            $response = $rows;
            return $response;
        } else {


            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function editclient($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $sql_clientedit = "SELECT * FROM `client` where client_id = '" . $data->client_id . "' ORDER BY created_by;";

            // echo $sql_clientedit; exit;
            $statement = $this->adapter->query($sql_clientedit);
            $result = $statement->execute();
            $rows = array_values(iterator_to_array($result));

            $response = array();
            $response = $rows;
            return $response;
        } else {


            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function updateclient($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";       // echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        //print_r($result->count()); exit;
        $resp = array();
        if ($result->count() >= 1) {

            $sql_client_update = "UPDATE `client` SET client_name = '" . $data->client_name . "',client_location = '" . $data->client_location . "',client_address = '" . $data->client_address . "',client_contact_person = '" . $data->client_contact_person . "',modified_by = '" . $data->id . "' WHERE client_id = '" . $data->client_id . "';";

            //  echo $sql_client_update; exit;
            $statement_update = $this->adapter->query($sql_client_update);
            $result = $statement_update->execute();

            $response = array();


            $response = array('state' => 'success', 'errorCode' => 555);
            return $response;
        } else {


            $response = array('errorMsg' => 'Token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function deleteclient($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";       // echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        //print_r($result->count()); exit;
        $resp = array();
        if ($result->count() >= 1) {
            $sql_client_update = "UPDATE `client` SET is_active = '0' WHERE client_id = '" . $data->client_id . "';";

            //$sql_client_delete = "DELETE FROM `client` WHERE `client`.`client_id` = '".$data->client_id."';";            
            //  echo $sql_client_update; exit;
            $statement_update = $this->adapter->query($sql_client_delete);
            $result = $statement_update->execute();

            $response = array();


            $response = array('state' => 'success', 'errorCode' => 777);
            return $response;
        } else {


            $response = array('errorMsg' => 'Token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function adduser($data) {

        $refnumber = md5($data->id . time());
        $refnumber = substr($refnumber, -6);

        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $tableName = "user";
            $sql_adduser = "INSERT INTO `{$tableName}` (
            `username`,
            `designation`,
            `dob`,
            `gender`,
            `doj`,
            `emergencycontact`,
            `mobile`,
            `email`,
            `address`,
            `picture`,
            `createdby`,
            `createddate`
             ) VALUES (
            '" . $data->username . "', 
            '" . $data->designation . "', 
            '" . $data->dob . "', 
            '" . $data->gender . "', 
            '" . $data->doj . "', 
            '" . $data->emergencycontact . "', 
            '" . $data->mobile . "', 
            '" . $data->email . "', 
            '" . $data->address . "',
            '" . $data->picture . "',
            '" . $data->id . "', 
            now() 
            )";
            // echo $sql_adduser; exit;
            $response = array();
            try {
                $statement = $this->adapter->query($sql_adduser);
                $res = $statement->execute();

                $response = array('id' => $data->id, 'status' => 'success');
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                if (strpos($msg, "1062") !== false) {
                    $response = array('errorCode' => 511, 'errorMsg' => 'sql error');
                }
            }

            return $response;
        } else {


            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function listuser($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $sql_userlist = "SELECT * FROM `user` ORDER BY createdby;";

            // echo $sql_userlist; exit;
            $statement = $this->adapter->query($sql_userlist);
            $result = $statement->execute();
            $rows = array_values(iterator_to_array($result));

            $response = array();
            $response = $rows;
            return $response;
        } else {


            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function edituser($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $sql_useredit = "SELECT * FROM `user` where userid = '" . $data->userid . "' ORDER BY createdby;";

            // echo $sql_clientedit; exit;
            $statement = $this->adapter->query($sql_useredit);
            $result = $statement->execute();
            $rows = array_values(iterator_to_array($result));

            $response = array();
            $response = $rows;
            return $response;
        } else {


            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function updateuser($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";       // echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        //print_r($result->count()); exit;
        $resp = array();
        if ($result->count() >= 1) {

            $sql_user_update = "UPDATE `user` SET username = '" . $data->username . "',designation = '" . $data->designation . "',dob = '" . $data->dob . "',gender = '" . $data->gender . "',doj = '" . $data->doj . "',emergencycontact = '" . $data->emergencycontact . "',mobile = '" . $data->mobile . "',email = '" . $data->email . "',address = '" . $data->address . "',picture = '" . $data->picture . "',modified_by = '" . $data->id . "' WHERE userid = '" . $data->userid . "';";

            // echo $sql_user_update; exit;
            $statement_update = $this->adapter->query($sql_user_update);
            $result = $statement_update->execute();

            $response = array();


            $response = array('state' => 'success', 'errorCode' => 555);
            return $response;
        } else {


            $response = array('errorMsg' => 'Token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function deleteuser($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";       // echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        //print_r($result->count()); exit;
        $resp = array();
        if ($result->count() >= 1) {

            $sql_user_delete = "DELETE FROM `user` WHERE `userid` = '" . $data->userid . "';";

            //  echo $sql_user_delete; exit;
            $statement_update = $this->adapter->query($sql_user_delete);
            $result = $statement_update->execute();

            $response = array();


            $response = array('state' => 'success', 'errorCode' => 777);
            return $response;
        } else {


            $response = array('errorMsg' => 'Token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function addaudit($data) {
        $refnumber = md5($data->id . time());
        $refnumber = substr($refnumber, -6);

        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $tableName = "audit";
            $sql_add_audit = "INSERT INTO `{$tableName}` (
            `client_id`,
            `audit_location`,
            `auditor`,
            `audit_date`,
            `audit_time`,
            `audit_status`,
            `created_by`,
            `created_date`,
            `modified_by`
             ) VALUES (
            '" . $data->client_id . "', 
            '" . $data->audit_location . "', 
            '" . $data->id . "', 
            '" . $data->audit_date . "', 
            '" . $data->audit_time . "', 
            '" . $data->audit_status . "', 
            '" . $data->id . "',
            now(),
            '" . $data->id . "'
            )";
            $response = array();
            try {
                $statement = $this->adapter->query($sql_add_audit);
                $res = $statement->execute();

                $response = array('lastInsertedId' => $res->getGeneratedValue(), 'id' => $data->id, 'status' => 'success', 'errorCode' => '');
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                if (strpos($msg, "1062") !== false) {
                    $response = array('errorCode' => 511, 'errorMsg' => 'sql error');
                }
            }

            return $response;
        } else {


            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function editaudit($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            // $sql_edit_audit = "SELECT * FROM `audit` where audit_id = '".$data->audit_id."' ORDER BY created_date;";



            $sql = new Sql($this->adapter);
            $select = $sql->select();
            $select->columns(array('*'));
            $select->from('audit');

            $select->join(array('client' => 'client'), 'audit.client_id = client.client_id', array('*'), $select::JOIN_LEFT);

            $select->join(array('user' => 'user'), 'audit.auditor = user.userid', array('*'), $select::JOIN_LEFT);



            $where = new Where();
            $where->equalTo('audit.audit_id', $data->audit_id);
            $select->where($where);
            //echo $select->getSqlString($this->adapter->getPlatform()); exit;
            $statement = $sql->prepareStatementForSqlObject($select);
            $result = $statement->execute();


            $rows = array_values(iterator_to_array($result));
            $response = array();
            $response = $rows;
            return $response;
        } else {


            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function deleteaudit($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";       // echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        //print_r($result->count()); exit;
        $resp = array();
        if ($result->count() >= 1) {

            $sql_audit_delete = "DELETE FROM `audit` WHERE `audit_id` = '" . $data->audit_id . "';";

            //  echo $sql_client_update; exit;
            $statement_update = $this->adapter->query($sql_audit_delete);
            $result = $statement_update->execute();

            $response = array();


            $response = array('state' => 'success', 'errorCode' => 777);
            return $response;
        } else {


            $response = array('errorMsg' => 'Token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function listaudit($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            //  $sql_audit_list = "SELECT * FROM `audit` ORDER BY created_date;";
            $sql = new Sql($this->adapter);
            $select = $sql->select();
            $select->columns(array('*'));
            $select->from('audit');
//
//            $select->join(array('client' => 'client'), 'audit.client_id = client.client_id', array('*'), $select::JOIN_LEFT); 
//
//            $select->join(array('user' => 'user'), 'audit.auditor = user.userid', array('*'), $select::JOIN_LEFT); 
            // $where = new  Where();
            // $where->equalTo( 'audit.audit_id', $data->audit_id );
            // $select->where($where);
            //echo $select->getSqlString($this->adapter->getPlatform()); exit;
            $statement = $sql->prepareStatementForSqlObject($select);
            $result = $statement->execute();


            $rows = array_values(iterator_to_array($result));
            $response = array();
            $response = $rows;
            return $response;



            // echo $sql_audit_list; exit;
            $statement = $this->adapter->query($sql_audit_list);
            $result = $statement->execute();
            $rows = array_values(iterator_to_array($result));

            $response = array();
            $response = $rows;
            return $response;
        } else {
            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');
            return $response;
        }
    }

    public function listclientaudit($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

//            $sql_audit_list = "SELECT * FROM `audit` where client_id = '".$data->clientid."' ORDER BY created_date;";



            $sql = new Sql($this->adapter);
            $select = $sql->select();
            $select->columns(array('*'));
            $select->from('audit');

            $select->join(array('client' => 'client'), 'audit.client_id = client.client_id', array('*'), $select::JOIN_LEFT);

            $select->join(array('user' => 'user'), 'audit.auditor = user.userid', array('*'), $select::JOIN_LEFT);



            $where = new Where();
            $where->equalTo('audit.client_id', $data->clientid);
            $select->where($where);
            $statement = $sql->prepareStatementForSqlObject($select);
            $result = $statement->execute();



            $rows = array_values(iterator_to_array($result));

            $response = array();
            $response = $rows;
            return $response;
        } else {


            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function addobservation($data) {

        $refnumber = md5($data->id . time());
        $refnumber = substr($refnumber, -6);

        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $tableName = "observation";
            $sql_add_obervation = "INSERT INTO `{$tableName}` (
            `observation_location`,
            `observation_description`,
            `observation_responsibility`,
            `observation_priority`,
            `observation_status`,
             `audit_id`,
            `created_by`,
            `created_date` 
             ) VALUES (
            '" . $data->observation_location . "', 
            '" . $data->observation_description . "', 
            '" . $data->observation_responsibility . "', 
            '" . $data->observation_priority . "', 
            '" . $data->observation_status . "', 
             '" . $data->audit_id . "',
            '" . $data->id . "',
             now() 
            )";
            // echo $sql_add_obervation; exit;
            $response = array();
            try {
                $statement = $this->adapter->query($sql_add_obervation);
                $res = $statement->execute();

                $response = array('id' => $data->id, 'status' => 'success');
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                if (strpos($msg, "1062") !== false) {
                    $response = array('errorCode' => 511, 'errorMsg' => 'sql error');
                }
            }

            return $response;
        } else {


            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function listobservation($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $sql_observation_list = "SELECT * FROM `observation` where audit_id = '" . $data->audit_id . "' ORDER BY created_date;";

            // echo $sql_observation_list; exit;
            $statement = $this->adapter->query($sql_observation_list);
            $result = $statement->execute();
            $rows = array_values(iterator_to_array($result));
            $response = array();
            $response = $rows;
            return $response;
        } else {


            $response = array('errorMsg' => 'token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function updateobservation($data) {


        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";       // echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        //print_r($result->count()); exit;
        $resp = array();
        if ($result->count() >= 1) {

            $sql_observation_update = "UPDATE `observation` SET observation_location = '" . $data->observation_location . "',observation_description = '" . $data->observation_description . "',observation_responsibility = '" . $data->observation_responsibility . "',observation_priority = '" . $data->observation_priority . "',modified_by = '" . $data->id . "' ,observation_status = '" . $data->observation_status . "' ,observation_image = '" . $data->observation_image . "' WHERE observation_id = '" . $data->observation_id . "';";

            //echo $sql_observation_update; exit;
            $statement_update = $this->adapter->query($sql_observation_update);
            $result = $statement_update->execute();

            $response = array();


            $response = array('state' => 'success', 'errorCode' => 555);
            return $response;
        } else {


            $response = array('errorMsg' => 'Token mismatch logout', 'errorCode' => 540, 'status' => 'failure');

            return $response;
        }
    }

    public function logoutadmin($data) {

        // echo "test"; exit;
        $token = md5($data->token . time());
        //$password =  md5($data->password);

        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $sql_update = "UPDATE `admin` SET token = '" . $token . "' WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";             // echo $sql; exit;
            $statement_update = $this->adapter->query($sql_update);
            $result = $statement_update->execute();


            $response = array('loginstatus' => 'success', 'errorCode' => 511);
            return $response;
        } else {
            $response = array('loginstatus' => 'failure', 'errorCode' => 512, 'errorMessage' => 'Invalid username or password');
            return $response;
        }
    }

    public function changepassword($data) {

        // echo "test"; exit;
        $token = md5($data->token . time());
        //$password =  md5($data->password);

        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $sql_update = "UPDATE `admin` SET password = '" . $data->password . "' WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";             // echo $sql; exit;
            $statement_update = $this->adapter->query($sql_update);
            $result = $statement_update->execute();


            $response = array('loginstatus' => 'success', 'errorCode' => 511);
            return $response;
        } else {
            $response = array('loginstatus' => 'failure', 'errorCode' => 512, 'errorMessage' => 'Invalid username or password');
            return $response;
        }
    }

    public function notificationsettings($data) {

        // echo "test"; exit;
        $token = md5($data->token . time());
        //$password =  md5($data->password);

        $sql = "SELECT * FROM `admin` WHERE id = '" . $data->id . "' and token = '" . $data->token . "';";     //  echo $sql; exit;
        $statement = $this->adapter->query($sql);
        $result = $statement->execute();
        $rows = array_values(iterator_to_array($result));
        $resp = array();
        if ($result->count() >= 1) {

            $sql_update = "UPDATE `notification_master` SET new_audit = '" . $data->new_audit . "',audit_sent = '" . $data->audit_sent . "',delete_audit = '" . $data->delete_audit . "',new_client = '" . $data->new_client . "' WHERE id = '" . $data->id . "';";

            // echo $sql_update; exit;
            $statement_update = $this->adapter->query($sql_update);
            $result = $statement_update->execute();


            $response = array('loginstatus' => 'success', 'errorCode' => 511);
            return $response;
        } else {
            $response = array('loginstatus' => 'failure', 'errorCode' => 512, 'errorMessage' => 'Invalid username or password');
            return $response;
        }
    }

}

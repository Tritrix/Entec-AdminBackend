<?php

//register

namespace Register\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Register\Model\RegisterTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Debug\Debug;
use Zend\View\Model\JsonModel;
use Zend\Validator\Db\RecordExists;
use Zend\Validator;
use Zend\Http\Client as HttpClient;
use Register\Service\RegisterService;
use Zend\Cache\StorageFactory;
use Zend\Service\Manager\ServiceLocatorInterface;
use Zend\EventManager\EventManagerAware;

class RegisterController extends AbstractActionController {

    public function adminloginAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->username) || $data->username == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Username should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->password) || $data->password == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Password should not be empty');
            return new JsonModel($resp);
        }



        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resplog = $registerService->adminlogin($data);


        if (isset($resplog) && (@$resplog['errorCode'] == 512)) {

            $resplog = array_merge($resplog, array('loginstatus' => 'failure'));
        } elseif (isset($resplog) && (@$resplog['errorCode'] == 511)) {
            $resplog = array_merge($resplog, array('loginstatus' => 'success'));
        } else {
            $resplog = array_merge($resplog, array('loginstatus' => 'failure', 'errorMessage' => 'sql error'));
        }
        return new JsonModel($resplog);
    }

    public function addclientAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

//        $request = $this->getRequest();
//          if($request->isPost()) { 
//                $target_dir = "public/clientlogo/";
//                $today = date("F j, Y, g:i a"); 
//                $target_file = $target_dir .$today. basename($_FILES["files"]["name"]);
//                if (move_uploaded_file($_FILES['files']['tmp_name'], $target_file)) {
//                         $logoPath = $target_file;
//                } else {
//                         $resp = array('status' => 'failure');
//                         return new JsonModel($resp);
//                }
//          } 

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);


        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->clientname) || $data->clientname == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Client name should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->location) || $data->location == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Location should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->address) || $data->address == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Address should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->contactperson) || $data->contactperson == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Contact person should not be empty');
            return new JsonModel($resp);
        }


        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->addclient($data);


        if (isset($resp) && (@$resp['errorCode'] == '513')) {

            $resp = array_merge($resp, array('status' => 'failure', 'errorcode' => 513, 'errorMessage' => 'Username already registered'));
        } elseif (isset($resp) && (@$resp['errorCode'] == '511')) {
            $resp = array_merge($resp, array('status' => 'failure', 'errorcode' => 511, 'errorMessage' => 'Sql error'));
        } else {
            //$resp = array_merge($resp, array('status' => 'failure'));
        }
        return new JsonModel($resp);
    }

    public function listclientAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->listclient($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function editclientAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->client_id) || $data->client_id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Client Id should not be empty');
            return new JsonModel($resp);
        }

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->editclient($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function updateclientAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->client_id) || $data->client_id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Client Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->client_name) || $data->client_name == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Client name should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->client_location) || $data->client_location == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Client Location should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->client_address) || $data->client_address == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Client Address should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->client_contact_person) || $data->client_contact_person == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Contact person should not be empty');
            return new JsonModel($resp);
        }


        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->updateclient($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function deleteclientAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->client_id) || $data->client_id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Client Id should not be empty');
            return new JsonModel($resp);
        }

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->deleteclient($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function adduserAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);

        // print_r($data);exit;
        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->username) || $data->username == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'User name should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->designation) || $data->designation == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Designation should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->dob) || $data->dob == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Date of birth should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->gender) || $data->gender == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'gender should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->doj) || $data->doj == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Date of joining should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->emergencycontact) || $data->emergencycontact == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Emergency contact should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->mobile) || $data->mobile == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Mobile should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->email) || $data->email == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Mobile should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->address) || $data->address == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Address should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->picture) || $data->picture == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Picture should not be empty');
            return new JsonModel($resp);
        }


        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->adduser($data);


        if (isset($resp) && (@$resp['errorCode'] == '513')) {

            $resp = array_merge($resp, array('status' => 'failure', 'errorcode' => 513, 'errorMessage' => 'Username already registered'));
        } elseif (!empty($resp) && $resp['errorCode'] == '511') {
            $resp = array_merge($resp, array('status' => 'failure', 'errorcode' => 511, 'errorMessage' => 'Sql error'));
        } else {
            //$resp = array_merge($resp, array('status' => 'failure'));
        }
        return new JsonModel($resp);
    }

    public function listuserAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->listuser($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function edituserAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->userid) || $data->userid == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'User Id should not be empty');
            return new JsonModel($resp);
        }

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->edituser($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function updateuserAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->userid) || $data->userid == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'User Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->username) || $data->username == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'User name should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->designation) || $data->designation == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Designation should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->dob) || $data->dob == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Date of birth should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->gender) || $data->gender == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Gernder should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->doj) || $data->doj == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Date of joining should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->emergencycontact) || $data->emergencycontact == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Emergency contact should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->mobile) || $data->mobile == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Mobile should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->email) || $data->email == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Email should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->address) || $data->address == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Address should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->picture) || $data->picture == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Picture should not be empty');
            return new JsonModel($resp);
        }


        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->updateuser($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function deleteuserAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->userid) || $data->userid == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'User Id should not be empty');
            return new JsonModel($resp);
        }

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->deleteuser($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function addauditAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);

        //print_r($data);exit;
        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->client_id) || $data->client_id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Client Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->audit_location) || $data->audit_location == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Audit Location should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->auditor) || $data->auditor == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Date of birth should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->audit_date) || $data->audit_date == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Audit date should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->audit_time) || $data->audit_time == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Audit time should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->audit_status) || $data->audit_status == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Audit status should not be empty');
            return new JsonModel($resp);
        }



        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->addaudit($data);


        if (isset($resp) && (@$resp['errorCode'] == '513')) {

            $resp = array_merge($resp, array('status' => 'failure', 'errorcode' => 513, 'errorMessage' => 'Username already registered'));
        } elseif (isset($resp) && (@$resp['errorCode'] == '511')) {
            $resp = array_merge($resp, array('status' => 'failure', 'errorcode' => 511, 'errorMessage' => 'Sql error'));
        } else {
            //$resp = array_merge($resp, array('status' => 'failure'));
        }
        return new JsonModel($resp);
    }

    public function editauditAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->audit_id) || $data->audit_id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Audit Id should not be empty');
            return new JsonModel($resp);
        }

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->editaudit($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function deleteauditAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->audit_id) || $data->audit_id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Audit Id should not be empty');
            return new JsonModel($resp);
        }

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->deleteaudit($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function listauditAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }


        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->listaudit($data);

        //print_r($resp); exit;
        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function listclientauditAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->clientid) || $data->clientid == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Client Id should not be empty');
            return new JsonModel($resp);
        }


        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->listclientaudit($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function addobservationAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);

        // print_r($data); exit;
        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->observation_location) || $data->observation_location == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Observation location should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->observation_description) || $data->observation_description == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Observation description should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->observation_responsibility) || $data->observation_responsibility == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Observation responsibility should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->observation_priority) || $data->observation_priority == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Observation priority should not be empty');
            return new JsonModel($resp);
        }


        if (!isset($data->observation_status) || $data->observation_status == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Observation status should not be empty');
            return new JsonModel($resp);
        }


        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->addobservation($data);


        if (isset($resp) && (@$resp['errorCode'] == '513')) {

            $resp = array_merge($resp, array('status' => 'failure', 'errorcode' => 513, 'errorMessage' => 'Username already registered'));
        } elseif (isset($resp) && (@$resp['errorCode'] == '511')) {
            $resp = array_merge($resp, array('status' => 'failure', 'errorcode' => 511, 'errorMessage' => 'Sql error'));
        } else {
            //$resp = array_merge($resp, array('status' => 'failure'));
        }
        return new JsonModel($resp);
    }

    public function updateobservationAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);

        // print_r($data); exit;
        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->observation_id) || $data->observation_id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Observation Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->observation_location) || $data->observation_location == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Observation location should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->observation_description) || $data->observation_description == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Observation description should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->observation_responsibility) || $data->observation_responsibility == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Observation responsibility should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->observation_priority) || $data->observation_priority == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Observation priority should not be empty');
            return new JsonModel($resp);
        }


        if (!isset($data->observation_status) || $data->observation_status == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Observation status should not be empty');
            return new JsonModel($resp);
        }

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->updateobservation($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function listobservationAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }
        if (!isset($data->audit_id) || $data->audit_id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Audit id should not be empty');
            return new JsonModel($resp);
        }


        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->listobservation($data);

        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function logoutadminAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }


        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->logoutadmin($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function changepasswordAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }
        if (!isset($data->password) || $data->password == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Password should not be empty');
            return new JsonModel($resp);
        }


        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->changepassword($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function notificationsettingsAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);



        if (!isset($data->id) || $data->id == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Id should not be empty');
            return new JsonModel($resp);
        }

        if (!isset($data->token) || $data->token == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Token should not be empty');
            return new JsonModel($resp);
        }
        if (!isset($data->new_audit) || $data->new_audit == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'New Audit should not be empty');
            return new JsonModel($resp);
        }
        if (!isset($data->audit_sent) || $data->audit_sent == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Audit sent should not be empty');
            return new JsonModel($resp);
        }
        if (!isset($data->delete_audit) || $data->delete_audit == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Delete audit should not be empty');
            return new JsonModel($resp);
        }
        if (!isset($data->new_client) || $data->new_client == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'New audit should not be empty');
            return new JsonModel($resp);
        }


        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $registerService = new RegisterService($dbAdapter);
        $resp = $registerService->notificationsettings($data);


        if (isset($resp) && (@$resp['errorCode'] == 540)) {

            $resp = array_merge($resp, array('status' => 'failure'));
        } else {
            $resp = array_merge($resp, array('status' => 'success'));
        }
        return new JsonModel($resp);
    }

    public function imageuploadAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $request = $this->getRequest();
        //print_r($_FILES); exit;
        if ($request->isPost()) {
            $files = $request->getFiles()->toArray();
            $target_dir = "public/images/";
            $target_file = $target_dir . basename($_FILES['files']['name']);
            if (move_uploaded_file($_FILES['files']['tmp_name'], $target_file)) {
                $resp = array('status' => 'success', 'file_path' => $target_file);
            } else {
                $resp = array('status' => 'failure');
            }
            //print_r($request->getFiles()->toArray()); exit;
            return new JsonModel($resp);
        }
    }

    public function audituploadAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $request = $this->getRequest();
        if ($request->isPost()) {
            $files = $request->getFiles()->toArray();
            $target_dir = "public/audit/";
            $target_file = $target_dir . basename($_FILES["files"]["name"]);
            if (move_uploaded_file($_FILES['files']['tmp_name'], $target_file)) {
                $resp = array('status' => 'success', 'file_path' => $target_file);
            } else {
                $resp = array('status' => 'failure');
            }
            return new JsonModel($resp);
        }
    }

    public function observationuploadAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $request = $this->getRequest();
        if ($request->isPost()) {
            $files = $request->getFiles()->toArray();
            $target_dir = "public/observation/";
            $target_file = $target_dir . basename($_FILES["files"]["name"]);
            if (move_uploaded_file($_FILES['files']['tmp_name'], $target_file)) {
                $resp = array('status' => 'success', 'file_path' => $target_file);
            } else {
                $resp = array('status' => 'failure');
            }
            return new JsonModel($resp);
        }
    }

    public function clientuploadAction() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent(); print_r($body);
        $data = json_decode($body);
print_r($data); exit;
        if (!isset($data->client_name) || $data->client_name == '') {
            $resp = array('status' => 'failure', 'errorCode' => 501, 'errorMessage' => 'Client Name should not be empty');
            return new JsonModel($resp);
        }


        $filename = $_FILES["files"]["name"];
        $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
        $file_ext = substr($filename, strripos($filename, '.')); // get file name
        $filesize = $_FILES["files"]["size"];
        $allowed_file_types = array('.png', '.jpg', '.jpeg');

        if (in_array($file_ext, $allowed_file_types) && ($filesize < 200000)) {
            // Rename file
            $newfilename = $data->client_name . $file_ext;

            if (move_uploaded_file($_FILES['files']['tmp_name'], "public/client/" . $newfilename)) {
                $resp = array('status' => 'success', 'file_path' => "public/client/" . $newfilename);
            } else {
                $resp = array('status' => 'failure');
            }
        } elseif (empty($file_basename)) {
            $resp = array('status' => 'failure', 'errorMessage' => 'Please select a file to upload.');
        } elseif ($filesize > 200000) {
            $resp = array('status' => 'failure', 'errorMessage' => 'The file you are trying to upload is too large.');
        } else {
            // file type error
            $resp = array('status' => 'failure', 'errorMessage' => "Only these file typs are allowed for upload: " . implode(', ', $allowed_file_types));
            unlink($_FILES["files"]["tmp_name"]);
        }

        return new JsonModel($resp);
    }

}

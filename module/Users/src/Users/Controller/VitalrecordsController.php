<?php
namespace Users\Controller;

use Zend\Validator\AbstractValidator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Users\Model\VitalrecordsTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
// use Zend\Debug\Debug;
use Zend\View\Model\JsonModel;

use Zend\Validator\Db\RecordExists;
use Zend\Http\Client as HttpClient;
use Users\Service\VitalrecordsService;

class VitalrecordsController extends AbstractRestfulController
{


     public function vitalrecordsAction()
    {
          
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        $body = $this->getRequest()->getContent();
        $data = json_decode($body);
	
		$user_id=$this->params('id');
		
		//METHOD GET
		///getting the vital records of patient
		
		if($this->getRequest()->getMethod() == 'GET') {
                $action = "getVitalrecords";
                $data = array( "user_id"=> $user_id  );
            }
		
		//METHOD POST
		//Inserting vital records into patients table
		if($this->getRequest()->getMethod() =='POST')
		{
				
			if( !isset($data->user_id) || $data->user_id == '') {
			$resp = array('status' => 'failure', 'errorCode' => 531, 'errorMessage' => 'Patient ID should not be empty');
			return new JsonModel($resp);
			}
			if( !isset($data->weight) || $data->weight == '') {
			$resp = array('status' => 'failure', 'errorCode' => 532, 'errorMessage' => 'Weight should not be empty');
			return new JsonModel($resp);
			}
			if( !isset($data->height) || $data->height == '') {
			$resp = array('status' => 'failure', 'errorCode' => 533, 'errorMessage' => 'height should not be empty');
			return new JsonModel($resp);
			}
			if( !isset($data->bp_high) || $data->bp_high == '') {
			$resp = array('status' => 'failure', 'errorCode' => 534, 'errorMessage' => 'bp high should not be empty');
			return new JsonModel($resp);
			}
			if( !isset($data->bp_low) || $data->bp_low == '') {
			$resp = array('status' => 'failure', 'errorCode' => 534, 'errorMessage' => 'bp low should not be empty');
			return new JsonModel($resp);
			}
			$action="createVitalrecord";
			$data=array("user_id"=> $data->user_id, "weight" => $data->weight, "height" => $data->height, "bp_high" => $data->bp_high, "bp_low" => $data->bp_low, "sugar_fasting" => $data->sugar_fasting, "sugar_pp" => $data->sugar_pp, "sugar_random" => $data->sugar_random, "hba1c" => $data->hba1c, "systolic" => $data->systolic, "diastolic" => $data->diastolic, "temperature" => $data->temperature, "created_date" => $data->created_date, "modified_date" => $data->modified_date);
			
		}
		
			$data = (object) $data;
			
			$sm = $this->getServiceLocator();
			$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
			
			$vitalrecordsService = new VitalrecordsService($dbAdapter);
			$resp = $vitalrecordsService->vitalrecords($action, $data);
		 
			if(!empty($resp) && !isset($resp['errorCode'])) {
				//mail for patient and doctor
				//push the notification
				$resp = array_merge($resp, array('status' => 'success'));
			} else {
				$resp = array_merge($resp, array('status' => 'failure'));
			}
			return new JsonModel($resp);
    }
	

	
	
    
}
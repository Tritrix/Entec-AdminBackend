<?php
namespace Users\Controller;

use Zend\Validator\AbstractValidator;
use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\View\Model\JsonModel;

use Zend\Http\Response;
use Users\Service\UsersService;

use Zend\Http\Client as HttpClient;

class UsersController extends AbstractRestfulController

{
 
    public function profileAction()
    {
        //echo "test atateds";exit;
        //$result = profileAction();
       header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
    
        
          if($this->getRequest()->getMethod() == 'GET') {
              
            //echo "congrats gan... you got it.... its a get method";
           // echo "test"; exit;
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PUT');
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");


            $id  = $this->params('id');

            $data = array("id"=>$id);
            $data = (object) $data;

            $sm = $this->getServiceLocator();
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $usersService = new UsersService($dbAdapter);
            $resp = $usersService->get($data);

            if(!empty($resp)) {
            $resp;
            } else {
            $resp = array('status' => 'failure', 'errorCode' => 523);
            }
            
     
        
//        echo $id;

//       echo 'get Method'; exit;
          }
        
        if($this->getRequest()->getMethod() == 'POST') {
            
            
			$id  = $this->params('id');
		
		
			//echo $data->gender . $data->country . $data->state . $data->city; exit;
			$body = $this->getRequest()->getContent();
			//print_r($body);exit;
			$data = json_decode($body);	
			
			if(empty($data)){
				$resp = array('status' => 'failure', 'errorCode' => 516, 'errorMessage' => 'json code format error');
				return new JsonModel($resp);
			}
			
			if ((strlen($data->mobile) >= 10) && (is_numeric($data->mobile))) {
				
			}
			else{
				$resp = array('status' => 'failure', 'errorCode' => 517, 'errorMessage' => 'mobile validation error');
          		return new JsonModel($resp);
			}
			
			if(($data->gender == '1') || ($data->gender == '2')){
				
			}
			else{
				$resp = array('status' => 'failure', 'errorCode' => 517, 'errorMessage' => 'gender validation error');
				return new JsonModel($resp);
			}
			
			if ((strlen($data->postal_code) >= 6) && (is_numeric($data->postal_code))) {
				
			}
			else{
				$resp = array('status' => 'failure', 'errorCode' => 517, 'errorMessage' => 'postalcode validation error');
          		return new JsonModel($resp);
			}
			
			if ((strlen($data->phone) >= 6) && (is_numeric($data->phone))) {
				
			}
			else{
				$resp = array('status' => 'failure', 'errorCode' => 517, 'errorMessage' => 'phonne validation error');
          		return new JsonModel($resp);
			}
			
			if (preg_match('/[a|b|ab|o|h][\+|\-|\/]/', $data->blood_group))  {
			}
			else{
				$resp = array('status' => 'failure', 'errorCode' => 517, 'errorMessage' => 'blood group validation error');
          		return new JsonModel($resp);
			
			}
			

			
			$sm = $this->getServiceLocator();
			$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
			$usersService = new UsersService($dbAdapter);
			$resp = $usersService->update($data,$id);
            
            if(empty($resp)) {
             $resp = array('status' => 'success');
            } else {
            $resp = array('status' => 'failure', 'errorCode' => 600);
            }
            return new JsonModel($resp);
            
            
			$resp = array('status' => 'success');
		 	//return new JsonModel($resp);
		
        }
          
        return new JsonModel($resp);

		          
	}
	
    
    
    public function countryAction()
    {
        //echo "country"; exit;

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        
        $sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$usersService = new UsersService($dbAdapter);
		$resp = $usersService->country();
        //print_r($resp); exit;
		//$resp = array('status' => 'success');
		return new JsonModel($resp);
		


		          
	}
    
    
    
    public function stateAction()
    {
        //echo "tesees"; exit;

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        
        $sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$usersService = new UsersService($dbAdapter);
		$resp = $usersService->state();
        //print_r($resp); exit;
		//$resp = array('status' => 'success');
		return new JsonModel($resp);
		


		          
	}
    
    
    public function cityAction()
    {

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        $id  = $this->params('id');
        
        if(empty($id)){
            $resp = array('status' => 'failure', 'errorCode' => 901, 'errorMessage' => 'state id is missing');
            return new JsonModel($resp);
        }
        
        if($id > 35){
            $resp = array('status' => 'failure', 'errorCode' => 902, 'errorMessage' => 'state id should be below 35');
            return new JsonModel($resp);
        }
        
        $sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$usersService = new UsersService($dbAdapter);
		$resp = $usersService->city($id);
        //print_r($resp); exit;
		//$resp = array('status' => 'success');
		return new JsonModel($resp);
		


		          
	}
    
    
    
    
	public function doctorprofileAction()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
    
        $body = $this->getRequest()->getContent();
		//print_r($body);exit;
		$data = json_decode($body);	
		$id  = $this->params('id');
		
		if(empty($data)){
		  $resp = array('status' => 'failure', 'errorCode' => 516, 'errorMessage' => 'json code format error');
          return new JsonModel($resp);
		}
		
		if($this->getRequest()->getMethod() == 'POST') {
			//echo $data->gender . $data->country . $data->state . $data->city; exit;
			if (is_numeric($data->council_number)) {
				
			}
			else{
				$resp = array('status' => 'failure', 'errorCode' => 519, 'errorMessage' => 'medical council number validation error');
          		return new JsonModel($resp);
			}
			

			$sm = $this->getServiceLocator();
			$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
			$usersService = new UsersService($dbAdapter);
			$resp = $usersService->doctorprofile($data,$id);
		}
		
		 return new JsonModel($resp);
   
	}
    
}
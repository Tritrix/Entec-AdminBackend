<?php
namespace Users\Controller;

use Zend\Validator\AbstractValidator;
use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\JsonModel;

use Zend\Http\Response;
use Users\Service\DoctorService;

use Zend\Http\Client as HttpClient;

class DoctorController extends AbstractActionController

{
    
    public function finddoctorAction()
    {
        
        //echo "doc home findsfdsfdfd doctor"; exit;
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        // $id  = $this->params('id');
        
         
        // {"msg_to":"1","msg_by":"3","subject":"sdfsdfdsdfdsf","message":"sdfsd dsf sdfsdf sdfsdfsdfsdfsd","sender_identity":"1"}
         
        //$body = $this->getRequest()->getContent();
		//print_r($body);exit;
		//$data = json_decode($body);	
         
        
         
        $sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$doctorService = new DoctorService($dbAdapter);
		$resp = $doctorService->finddoctor();
        //print_r($resp); exit;
        if(empty($resp))
        {
            $resp = array('status' => 'no doctors found');
        
        }
		return new JsonModel($resp);
		


		          
	}
	
    
}
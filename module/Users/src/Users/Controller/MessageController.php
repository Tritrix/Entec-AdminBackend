<?php
namespace Users\Controller;

use Zend\Validator\AbstractValidator;
use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\JsonModel;

use Zend\Http\Response;
use Users\Service\MessageService;

use Zend\Http\Client as HttpClient;

class MessageController extends AbstractActionController

{
 
    
     public function messageAction()
    {
        // echo "message home"; exit;
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        // $id  = $this->params('id');
        
         
        // {"msg_to":"1","msg_by":"3","subject":"sdfsdfdsdfdsf","message":"sdfsd dsf sdfsdf sdfsdfsdfsdfsd","sender_identity":"1"}
         
        $body = $this->getRequest()->getContent();
		//print_r($body);exit;
		$data = json_decode($body);	
         
         
        if(empty($data->msg_to)){
            $resp = array('status' => 'failure', 'errorCode' => 903, 'errorMessage' => 'message sender id should not be empty');
            return new JsonModel($resp);
        }
         
        if (!is_numeric($data->msg_to)) {
			$resp = array('status' => 'failure', 'errorCode' => 903, 'errorMessage' => 'message sender id should be numeric');
            return new JsonModel($resp);	
        }
         
        if(empty($data->msg_by)){
            $resp = array('status' => 'failure', 'errorCode' => 903, 'errorMessage' => 'message by id should not be empty');
            return new JsonModel($resp);
        }
         
        if (!is_numeric($data->msg_by)) {
			$resp = array('status' => 'failure', 'errorCode' => 903, 'errorMessage' => 'message by id should be numeric');
            return new JsonModel($resp);	
        }
         
        if(empty($data->subject)){
            $resp = array('status' => 'failure', 'errorCode' => 903, 'errorMessage' => 'message subject should not be empty');
            return new JsonModel($resp);
        }
         
        if(empty($data->message)){
            $resp = array('status' => 'failure', 'errorCode' => 903, 'errorMessage' => 'message should not be empty');
            return new JsonModel($resp);
        }
         
        if(empty($data->sender_identity)){
            $resp = array('status' => 'failure', 'errorCode' => 903, 'errorMessage' => 'sender identity not be empty');
            return new JsonModel($resp);
        }
         
        if (!is_numeric($data->sender_identity)) {
			$resp = array('status' => 'failure', 'errorCode' => 903, 'errorMessage' => 'sender identity should be numeric');
            return new JsonModel($resp);	
        }

         if (($data->sender_identity) > 2) {
			$resp = array('status' => 'failure', 'errorCode' => 903, 'errorMessage' => 'sender identity should be 1 or 2 , 1 for patient, 2 for doctor');
            return new JsonModel($resp);	
        }
        
         
        $sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$messageService = new MessageService($dbAdapter);
		$resp = $messageService->message($data);
        //print_r($resp); exit;
        if(empty($resp))
        {
            $resp = array('status' => 'success');
        
        }
		return new JsonModel($resp);
		


		          
	}
    
    
    
    
    
    public function inboxAction()
    {
        
        if($this->getRequest()->getMethod() == 'GET') 
        {

            // echo "message inbox"; exit;
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: *');
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
            $id  = $this->params('id');

            // {"msg_to":"1","msg_by":"3","subject":"sdfsdfdsdfdsf","message":"sdfsd dsf sdfsdf sdfsdfsdfsdfsd","sender_identity":"1"}

            //$body = $this->getRequest()->getContent();
            //print_r($body);exit;
            //$data = json_decode($body);	

             if(empty($id)){
                $resp = array('status' => 'failure', 'errorCode' => 905, 'errorMessage' => 'sender id missing');
                return new JsonModel($resp);
            }

            $sm = $this->getServiceLocator();
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $messageService = new MessageService($dbAdapter);
            $resp = $messageService->inbox($id);
            //print_r($resp); exit;
            if(empty($resp))
            {
                $resp = array('status' => 'empty');

            }
            return new JsonModel($resp);
        }
        
        if($this->getRequest()->getMethod() == 'POST') 
        {
            
            //  echo "message inbox to archive"; exit;
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: *');
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
            $id  = $this->params('id');

            // {"msg_to":"1","msg_by":"3","subject":"sdfsdfdsdfdsf","message":"sdfsd dsf sdfsdf sdfsdfsdfsdfsd","sender_identity":"1"}

            $body = $this->getRequest()->getContent();
            //print_r($body);exit;
            $data = json_decode($body);	
            
            //print_r($data->message_id); exit;
            
           $message_id = $data->message_id; 
                        
             if(empty($id)){
                $resp = array('status' => 'failure', 'errorCode' => 905, 'errorMessage' => 'sender id missing');
                return new JsonModel($resp);
            }

            $sm = $this->getServiceLocator();
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $messageService = new MessageService($dbAdapter);
            $resp = $messageService->inboxtoarchive($id,$message_id);
            //print_r($resp); exit;
            if(empty($resp))
            {
                $resp = array('status' => 'success');

            }
            return new JsonModel($resp);
            
        }


		          
	}
    
    
    
    public function outboxAction()
    {
         if($this->getRequest()->getMethod() == 'POST') 
        {
                $resp = array();
                $resp = array('status' => 'Use GET method for Sent items');
                return new JsonModel($resp);
        }
        
        if($this->getRequest()->getMethod() == 'GET') 
        {
        // echo "message outbox"; exit;
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        $id  = $this->params('id');
        
        // {"msg_to":"1","msg_by":"3","subject":"sdfsdfdsdfdsf","message":"sdfsd dsf sdfsdf sdfsdfsdfsdfsd","sender_identity":"1"}
         
        //$body = $this->getRequest()->getContent();
		//print_r($body);exit;
		//$data = json_decode($body);	
         
         if(empty($id)){
            $resp = array('status' => 'failure', 'errorCode' => 905, 'errorMessage' => 'sender id missing');
            return new JsonModel($resp);
        }
         
        $sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$messageService = new MessageService($dbAdapter);
		$resp = $messageService->outbox($id);
        //print_r($resp); exit;
        if(empty($resp))
        {
            $resp = array('status' => 'empty');
        
        }
		return new JsonModel($resp);
		

    }
		          
	}
    
    
    
     public function archiveAction()
    {
        
        if($this->getRequest()->getMethod() == 'GET') 
        {

            // echo "message archive"; exit;
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: *');
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
            $id  = $this->params('id');

            // {"msg_to":"1","msg_by":"3","subject":"sdfsdfdsdfdsf","message":"sdfsd dsf sdfsdf sdfsdfsdfsdfsd","sender_identity":"1"}

            //$body = $this->getRequest()->getContent();
            //print_r($body);exit;
            //$data = json_decode($body);	

             if(empty($id)){
                $resp = array('status' => 'failure', 'errorCode' => 905, 'errorMessage' => 'sender id missing');
                return new JsonModel($resp);
            }

            $sm = $this->getServiceLocator();
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $messageService = new MessageService($dbAdapter);
            $resp = $messageService->archive($id);
            //print_r($resp); exit;
            if(empty($resp))
            {
                $resp = array('status' => 'empty');

            }
            return new JsonModel($resp);
        }
        
        if($this->getRequest()->getMethod() == 'POST') 
        {
            
            //  echo "message archive to inbox"; exit;
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: *');
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
            $id  = $this->params('id');

            // {"msg_to":"1","msg_by":"3","subject":"sdfsdfdsdfdsf","message":"sdfsd dsf sdfsdf sdfsdfsdfsdfsd","sender_identity":"1"}

            $body = $this->getRequest()->getContent();
            //print_r($body);exit;
            $data = json_decode($body);	
            
            //print_r($data->message_id); exit;
            
           $message_id = $data->message_id; 
                        
             if(empty($id)){
                $resp = array('status' => 'failure', 'errorCode' => 905, 'errorMessage' => 'sender id missing');
                return new JsonModel($resp);
            }

            $sm = $this->getServiceLocator();
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $messageService = new MessageService($dbAdapter);
            $resp = $messageService->archivetoinbox($id,$message_id);
            //print_r($resp); exit;
            if(empty($resp))
            {
                $resp = array('status' => 'success');

            }
            return new JsonModel($resp);
            
        }


		          
	}
    
    
    
    
    
    
    public function deleteAction()
    {
        
        if($this->getRequest()->getMethod() == 'GET') 
        {
            //echo "list all delete messages"; exit;
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: *');
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
            $id  = $this->params('id');

            // {"msg_to":"1","msg_by":"3","subject":"sdfsdfdsdfdsf","message":"sdfsd dsf sdfsdf sdfsdfsdfsdfsd","sender_identity":"1"}

            //$body = $this->getRequest()->getContent();
            //print_r($body);exit;
            //$data = json_decode($body);	

             if(empty($id)){
                $resp = array('status' => 'failure', 'errorCode' => 905, 'errorMessage' => 'sender id missing');
                return new JsonModel($resp);
            }

            $sm = $this->getServiceLocator();
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $messageService = new MessageService($dbAdapter);
            $resp = $messageService->listdelete($id);
            //print_r($resp); exit;
            if(empty($resp))
            {
                $resp = array('status' => 'empty');

            }
            return new JsonModel($resp);
        }
        
        if($this->getRequest()->getMethod() == 'POST') 
        {
            
            //echo "message delete"; exit;
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: *');
            header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
            $id  = $this->params('id');

            // {"msg_to":"1","msg_by":"3","subject":"sdfsdfdsdfdsf","message":"sdfsd dsf sdfsdf sdfsdfsdfsdfsd","sender_identity":"1"}

            $body = $this->getRequest()->getContent();
            //print_r($body);exit;
            $data = json_decode($body);	
            
            //print_r($data->message_id); exit;
            
           $message_id = $data->message_id; 
                        
             if(empty($id)){
                $resp = array('status' => 'failure', 'errorCode' => 905, 'errorMessage' => 'sender id missing');
                return new JsonModel($resp);
            }

            $sm = $this->getServiceLocator();
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $messageService = new MessageService($dbAdapter);
            $resp = $messageService->delete($id,$message_id);
            //print_r($resp); exit;
            if(empty($resp))
            {
                $resp = array('status' => 'success');

            }
            return new JsonModel($resp);
            
        }


		          
	}
    
    
    
	
    
}
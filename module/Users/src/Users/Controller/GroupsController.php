<?php
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;
use Users\Service\GroupsService;

use Zend\Validator\AbstractValidator;



class GroupsController extends AbstractRestfulController
{
    
    //Collections of Groups
    public function getList() {
        //getList method is allowed
        
        // $this->methodNotAllowed();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        $body = $this->getRequest()->getContent();
        $data = json_decode($body);
        
        //user id exists and fetch the Groups for the user
        $userID = $this->params( 'user_id' );
        $data = array( "userID" => $userID  );
        $data = (object) $data;
        //print_r($data); exit;

        $sm = $this->getServiceLocator();
		$adapter = $sm->get('Zend\Db\Adapter\Adapter');
        $groupsService = new GroupsService( $adapter );
        
        $resp = $groupsService->getList( $data );
       
        if(!empty( $resp ) && !isset( $resp['errorCode'] )) {
            $resp = array_merge($resp, array('status' => 'success'));
        } else {
            $resp = array_merge( $resp, array('status' => 'failure' ));
        }
        //print_r($resp); exit;
        return new JsonModel($resp);
    }

    //Get the Single Group
    public function get() {
       
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

        //Based on the url, appointments action varies
        $body = $this->getRequest()->getContent();
        $data = json_decode($body);
        
        print_r($data); exit;
        $userID = $this->params('user_id');
        $aptID = $this->params('id');
       

        $data = array( "userID" => $userID, "aptID"=> $aptID );

        $data = (object) $data;

        $sm = $this->getServiceLocator();
        $adapter = $sm->get('Zend\Db\Adapter\Adapter');
        $groupsService = new GroupsService( $adapter );

        $resp = $groupsService->get( $data );

        if(!empty( $resp ) && !isset( $resp['errorCode'] )) {
        $resp = array_merge( $resp, array( 'status' => 'success' ));
        } else {
        $resp = array_merge( $resp, array( 'status' => 'failure' ));
        }
        // print_r($resp); exit;
        return new JsonModel( $resp );
    }
    
    
    //Create the Single Group
    public function create() {
       
    
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        
        $userID = $this->params('user_id');
        
       
        
        //Based on the url, appointments action varies
        $body = $this->getRequest()->getContent();
        $data = json_decode($body);
        
        if(empty($data))
        {
				$resp = array('status' => 'failure', 'errorCode' => 516, 'errorMessage' => 'json code format error');
				return new JsonModel($resp);
		}
              
        if( !isset( $userID ) || empty( $userID ) ) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'User ID should not be empty');
            return new JsonModel($resp);
        }


        if( !isset( $data->group_name ) || empty($data->group_name )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Group name should not be empty');
            return new JsonModel($resp);
        }

        if (is_numeric($data->group_type)) 
        {
				
		}
		else
        {
		  $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Group type validation error');
          return new JsonModel($resp);
		}
        
        
        if( !isset( $data->group_description ) || empty($data->group_description )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Group description should not be empty');
            return new JsonModel($resp);
        }

       
        if( !isset( $data->group_type ) || empty($data->group_type )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Group type should not be empty');
            return new JsonModel($resp);
        }
        
        if( !isset( $data->address1 ) || empty($data->address1 )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Group address should not be empty');
            return new JsonModel($resp);
        }
        
        if( !isset( $data->city ) || empty($data->city )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'City should not be empty');
            return new JsonModel($resp);
        }
        
         if( !isset( $data->phone1 ) || empty($data->phone1 )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Phone should not be empty');
            return new JsonModel($resp);
        }
        
         if( !isset( $data->mobile1 ) || empty($data->mobile1 )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Mobile should not be empty');
            return new JsonModel($resp);
        }
        
        if ((strlen($data->phone1) >= 6) && (is_numeric($data->phone1))) 
        {
				
		}
		else
        {
		  $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'phonne validation error');
          return new JsonModel($resp);
		}
        
        if ((strlen($data->postal_code) >= 6) && (is_numeric($data->postal_code))) 
        {
				
		}
		else
        {
		  $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'postalcode validation error');
          return new JsonModel($resp);
		}
        
        if ((strlen($data->mobile1) >= 10) && (is_numeric($data->mobile1))) 
        {
				
		}
		else
        {
		  $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'mobile validation error');
          return new JsonModel($resp);
		}
        
    
        //$data = (object) $data;

        $sm = $this->getServiceLocator();
		$adapter = $sm->get('Zend\Db\Adapter\Adapter');
        $groupsService = new GroupsService( $adapter );
        
        $resp = $groupsService->create($data,$userID);
        
        //print_r($resp); exit;
        
        if(!empty( $resp ) && !isset( $resp['errorCode'] )) {
            $resp = array_merge( $resp, array('status' => 'success'));
        } else {
            $resp = array_merge( $resp, array('status' => 'failure' ));
        }
        // print_r($resp); exit;
        return new JsonModel($resp);
    }
    
    
    
    
    
    
    
    
    //update :: update
     public function update() {

         $userID = $this->params('user_id');
         $grpID = $this->params('id'); 
        
        
        //Based on the url, appointments action varies
        $body = $this->getRequest()->getContent();
        $data = json_decode($body);

        //print_r($data); exit;
        if(empty($data))
        {
				$resp = array('status' => 'failure', 'errorCode' => 516, 'errorMessage' => 'json code format error');
				return new JsonModel($resp);
		}
              
        if( !isset( $userID ) || empty( $userID ) ) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'User ID should not be empty');
            return new JsonModel($resp);
        }


        if( !isset( $data->group_name ) || empty($data->group_name )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Group name should not be empty');
            return new JsonModel($resp);
        }

        
        if( !isset( $data->group_description ) || empty($data->group_description )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Group description should not be empty');
            return new JsonModel($resp);
        }

       
       
        if( !isset( $data->address1 ) || empty($data->address1 )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Group address should not be empty');
            return new JsonModel($resp);
        }
        
        if( !isset( $data->city ) || empty($data->city )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'City should not be empty');
            return new JsonModel($resp);
        }
        
         if( !isset( $data->phone1 ) || empty($data->phone1 )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Phone should not be empty');
            return new JsonModel($resp);
        }
        
         if( !isset( $data->mobile1 ) || empty($data->mobile1 )) {
            $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'Mobile should not be empty');
            return new JsonModel($resp);
        }
        
        if ((strlen($data->phone1) >= 6) && (is_numeric($data->phone1))) 
        {
				
		}
		else
        {
		  $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'phonne validation error');
          return new JsonModel($resp);
		}
        
        if ((strlen($data->postal_code) >= 6) && (is_numeric($data->postal_code))) 
        {
				
		}
		else
        {
		  $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'postalcode validation error');
          return new JsonModel($resp);
		}
        
        if ((strlen($data->mobile1) >= 10) && (is_numeric($data->mobile1))) 
        {
				
		}
		else
        {
		  $resp = array('status' => 'failure', 'errorCode' => 801, 'errorMessage' => 'mobile validation error');
          return new JsonModel($resp);
		}
        
    
        //$data = (object) $data;
        $data = json_decode($body,true);
        //array_push($data, array("userid"=>$userID), $grpID);
        $data = array_merge( $data, array('userID' => $userID, 'grpID' => $grpID));
        
        $sm = $this->getServiceLocator();
		$adapter = $sm->get('Zend\Db\Adapter\Adapter');
        $groupsService = new GroupsService( $adapter );
        
        $resp = $groupsService->update($data);
        
        
         
         
        //print_r($resp); exit;
        
        if(!empty( $resp ) && !isset( $resp['errorCode'] )) {
            $resp = array_merge( $resp, array('status' => 'success'));
        } else {
            //$resp = array_merge( $resp, array('status' => 'failure' ));
            $resp;
        }
        // print_r($resp); exit;
        return new JsonModel($resp);
         
         
     }
    
    
    
    
    
    
    
    //Delete the Single Appointment
    public function delete() { 
    
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
       
        //Based on the url, appointments action varies
        //$body = $this->getRequest()->getContent();
        //$data = json_decode($body);
        

        $userID = $this->params('user_id');
        $grpID = $this->params('id');
       
        $data = array( "patID" => $userID, "grpID"=> $grpID );
        $data = (object) $data;

        $sm = $this->getServiceLocator();
		$adapter = $sm->get('Zend\Db\Adapter\Adapter');
        $groupsService = new GroupsService( $adapter );
        
        $resp = $groupsService->delete( $data );
       
        if(!empty( $resp ) && !isset( $resp['errorCode'] )) {
            $resp = array_merge( $resp, array('status' => 'success'));
        } else {
            $resp = array_merge( $resp, array('status' => 'failure' ));
        }
        // print_r($resp); exit;
        return new JsonModel($resp);
    }
    
    
    // configure response
    public function getResponseWithHeader()
    {
        $response = $this->getResponse();
        $response->getHeaders()
                 //make can accessed by *   
                 ->addHeaderLine('Access-Control-Allow-Origin','*')
                 //set allow methods
                 ->addHeaderLine('Access-Control-Allow-Methods','POST PUT DELETE GET');
         
        return $response;
    }

    
}
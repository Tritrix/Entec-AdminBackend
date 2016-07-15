<?php
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;
use Users\Service\AppointmentsService;

use Zend\Cache\StorageFactory;
use Zend\Service\Manager\ServiceLocatorInterface;
use Zend\EventManager\EventManagerAware;

use Zend\Http\Request;
use Zend\Http\Client as HttpClient;

use Users\Controller\AuthenticationController;

class AppointmentsController extends AbstractRestfulController
{
    
    //THUMB RULE TO FOLLOW
    /*
    
        1.  SET HEADERS
        2.  CHECK QUERY STRING ($this->params) VALIDATION
        3.  CHECK AUTHENTICATION OF THE USER
        4.  CHECK FOR $data ARRAY VALIDATION (ONLY CREATE, UPDATE METHOD)
        5.  CALL THE SERVICE FUNCTION 
        6.  GET THE RESPONSE AND SET THE PROPER SUCESS MSG or FAILURE MSG
    
    */
    
    //Collections of Appointments
    public function getList() {
        
        //Check for getList method is allowed
        //?
        
        // $this->methodNotAllowed();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        
        //user id exists and fetch the appointments for the user
        $userID = $this->params( 'user_id' );
        if( !isset( $userID ) || empty( $userID ) ) {
            $resp = array('status' => 'failure', 'errorCode' => 531, 'errorMessage' => 'User ID should not be empty');
            return new JsonModel($resp);
        }
        
         //#401 => check authorization token against the server cache token
        $headerToken = $this->getRequest()->getHeaders('authorization')->getFieldValue();
        $authenticationController = new AuthenticationController( $this->getServiceLocator()->get('cache') );
        $dataAuthentication = (object) array( "userID" => $userID, "headerToken" => $headerToken ); 
        $resp = $authenticationController->isAuthentic( $dataAuthentication );
        //if Authentication failure
        if( isset( $resp['status'] ) && $resp['status'] == 'failure' )   {
         $this->response->setStatusCode( 401 );
         return new JsonModel($resp);
        }
        
        //adapter
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $appointmentsService = new AppointmentsService( $adapter );
        
        //service function
        $data = (object) array( "patID" => $userID  );
        $resp = $appointmentsService->getList( $data );
       
        if(!empty( $resp ) && !isset( $resp['errorCode'] )) {
            $resp = array_merge($resp, array('status' => 'success'));
        } else {
            $resp = array_merge( $resp, array('status' => 'failure' ));
        }
        // print_r($resp); exit;
        return new JsonModel($resp);
    }

    //Get the Single Appointment
    public function get() {
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        
        $userID = $this->params('user_id');
        $aptID = $this->params('id');
        
        //check user id exists
        if( !isset( $userID ) || empty( $userID ) ) {
            $resp = array('status' => 'failure', 'errorCode' => 531, 'errorMessage' => 'Patient ID should not be empty');
            return new JsonModel($resp);
        }
        
        //check appointment id exists
        if( !isset( $aptID ) || empty( $aptID ) ) {
            $resp = array('status' => 'failure', 'errorCode' => 531, 'errorMessage' => 'Appointment ID should not be empty');
            return new JsonModel($resp);
        }
        
        //#401 => check authorization token against the server cache token
        $headerToken = $this->getRequest()->getHeaders('authorization')->getFieldValue();
        $authenticationController = new AuthenticationController( $this->getServiceLocator()->get('cache') );
        $dataAuthentication = (object) array( "userID" => $userID, "headerToken" => $headerToken ); 
        $resp = $authenticationController->isAuthentic( $dataAuthentication );
        //if Authentication failure
        if( isset( $resp['status'] ) && $resp['status'] == 'failure' )   {
         $this->response->setStatusCode( 401 );
         return new JsonModel($resp);
        }
        
        $data = (object) array( "patID" => $userID, "aptID"=> $aptID );
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $appointmentsService = new AppointmentsService( $adapter );
        $resp = $appointmentsService->get( $data );
        if(!empty( $resp ) && !isset( $resp['errorCode'] )) {
            $resp = array_merge( $resp, array( 'status' => 'success' ));
        } else {
            $this->response->setStatusCode( 404 );
            $resp = array_merge( $resp, array( 'status' => 'failure' ));
        }
        // print_r($resp); exit;
        return new JsonModel( $resp );
    }
    
   
    
    
    //Create the Single Appointment
    public function create() {
       
    
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        
        $userID = $this->params('user_id');
        
        //check user id exists
        if( !isset( $userID ) || empty( $userID ) ) {
            $resp = array('status' => 'failure', 'errorCode' => 531, 'errorMessage' => 'Patient ID should not be empty');
            return new JsonModel($resp);
        }

        //#401 => check authorization token against the server cache token
        $headerToken = $this->getRequest()->getHeaders('authorization')->getFieldValue();
        $authenticationController = new AuthenticationController( $this->getServiceLocator()->get('cache') );
        $dataAuthentication = (object) array( "userID" => $userID, "headerToken" => $headerToken ); 
        $resp = $authenticationController->isAuthentic( $dataAuthentication );
        //if Authentication failure
        if( isset( $resp['status'] ) && $resp['status'] == 'failure' )   {
         $this->response->setStatusCode( 401 );
         return new JsonModel($resp);
        }
        
        
        //Based on the url, appointments action varies
        $body = $this->getRequest()->getContent();
        $data = json_decode($body);
        
        //check $data
        if(empty($data))    {
				$resp = array('status' => 'failure', 'errorCode' => 516, 'errorMessage' => 'json code format error');
				return new JsonModel($resp);
		}
              
        if( !isset( $data->pat_id ) || empty( $data->pat_id ) ) {
            $resp = array('status' => 'failure', 'errorCode' => 531, 'errorMessage' => 'Patient ID should not be empty');
            return new JsonModel($resp);
        }


        if( !isset( $data->doc_id ) || empty($data->doc_id )) {
            $resp = array('status' => 'failure', 'errorCode' => 532, 'errorMessage' => 'Doctor ID should not be empty');
            return new JsonModel($resp);
        }

        if( !isset( $data->apt_time ) || empty($data->apt_time )) {
            $resp = array('status' => 'failure', 'errorCode' => 533, 'errorMessage' => 'Appointment time should not be empty');
            return new JsonModel($resp);
        }

        if( !isset( $data->apt_subject ) || empty($data->apt_subject )) {
            $resp = array('status' => 'failure', 'errorCode' => 534, 'errorMessage' => 'Appointment Subject time should not be empty');
            return new JsonModel($resp);
        }

        $data = (object) array( "patID" => $data->pat_id, "docID" => $data->doc_id, "aptTime" => $data->apt_time , "aptSubject" => $data->apt_subject , "aptDesc" => $data->apt_desc );
        
        $sm = $this->getServiceLocator();
		$adapter = $sm->get('Zend\Db\Adapter\Adapter');
        $appointmentsService = new AppointmentsService( $adapter );
        $resp = $appointmentsService->create( $data );
       
        if(!empty( $resp ) && !isset( $resp['errorCode'] )) {
            $resp = array_merge( $resp, array('status' => 'success'));
        } else {
            $resp = array_merge( $resp, array('status' => 'failure' ));
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
        $body = $this->getRequest()->getContent();
        $data = json_decode($body);

        $userID = $this->params('user_id');
        $aptID = $this->params('id');
       
        //#401 => check authorization token against the server cache token
        $headerToken = $this->getRequest()->getHeaders('authorization')->getFieldValue();
        $authenticationController = new AuthenticationController( $this->getServiceLocator()->get('cache') );
        $dataAuthentication = (object) array( "userID" => $userID, "headerToken" => $headerToken ); 
        $resp = $authenticationController->isAuthentic( $dataAuthentication );
        //if Authentication failure
        if( isset( $resp['status'] ) && $resp['status'] == 'failure' )   {
         $this->response->setStatusCode( 401 );
         return new JsonModel($resp);
        }
        
        $data = (object) array( "patID" => $userID, "aptID"=> $aptID );
        $sm = $this->getServiceLocator();
		$adapter = $sm->get('Zend\Db\Adapter\Adapter');
        $appointmentsService = new AppointmentsService( $adapter );
        
        $resp = $appointmentsService->delete( $data );
       
        if(!empty( $resp ) && !isset( $resp['errorCode'] )) {
            $resp = array_merge( $resp, array('status' => 'success'));
        } else {
            $this->response->setStatusCode( 404 );
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
<?php
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;
//use Users\Service\AuthenticationService;

use Zend\Cache\StorageFactory;
use Zend\Service\Manager\ServiceLocatorInterface;
use Zend\EventManager\EventManagerAware;

use Zend\Http\Request;
use Zend\Http\Client as HttpClient;

class AuthenticationController extends AbstractRestfulController
{
    
    public function __construct( $cache ) {
      $this->cache = $cache;
    }
  
    public function isAuthentic($dataAuthentication )   {
        $token = $this->cache->getItem($dataAuthentication->userID);
        //Error Code - 401 :: Authentication Failure
        if( !isset($token) || empty($token) ||  ($token != $dataAuthentication->headerToken)  )   {
            $resp = array('status' => 'failure', 'errorCode' => 401, 'errorMessage' => 'Authentication failiure');
        return $resp;    
        }
            $resp = array('status' => 'sucess');
        return $resp;   
    }
  
    
}
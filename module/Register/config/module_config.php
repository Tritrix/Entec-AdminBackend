<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Register\Controller\Register' => 'Register\Controller\RegisterController',
        ),
    ),
	
    'router' => array(
        'routes' => array(
        

          
         
            'adminlogin' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/adminlogin',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'adminlogin',
                    ),
                ),
            ),
			
			 'addclient' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/addclient',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'addclient',
                    ),
                ),
            ),
			
			
			 'listclient' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/listclient',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'listclient',
                    ),
                ),
            ),
            
             'editclient' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/editclient',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'editclient',
                    ),
                ),
            ),
            
			
			'updateclient' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/updateclient',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'updateclient',
                    ),
                ),
            ),
            
            'deleteclient' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/deleteclient',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'deleteclient',
                    ),
                ),
            ),
            
            'adduser' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/adduser',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'adduser',
                    ),
                ),
            ),
            
			'listuser' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/listuser',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'listuser',
                    ),
                ),
            ),
            
            
			  'edituser' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/edituser',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'edituser',
                    ),
                ),
            ),
            
			'updateuser' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/updateuser',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'updateuser',
                    ),
                ),
            ),
			
			 'deleteuser' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/deleteuser',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'deleteuser',
                    ),
                ),
            ),
            
			
			 'addaudit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/addaudit',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'addaudit',
                    ),
                ),
            ),
            
			 'editaudit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/editaudit',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'editaudit',
                    ),
                ),
            ),
            
			
			
			 'deleteaudit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/deleteaudit',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'deleteaudit',
                    ),
                ),
            ),
            
			
			 'listaudit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/listaudit',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'listaudit',
                    ),
                ),
            ),
			
			
			 'listclientaudit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/listclientaudit',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'listclientaudit',
                    ),
                ),
            ),
			
			 'addobservation' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/addobservation',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'addobservation',
                    ),
                ),
            ),
            
            	 'updateobservation' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/updateobservation',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'updateobservation',
                    ),
                ),
            ),
			
             'listobservation' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/listobservation',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'listobservation',
                    ),
                ),
            ),
			
             
             'logoutadmin' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/logoutadmin',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'logoutadmin',
                    ),
                ),
            ),
			
              'changepassword' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/changepassword',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'changepassword',
                    ),
                ),
            ),
			
               'notification_settings' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/notificationsettings',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'notificationsettings',
                    ),
                ),
            ),
			
			
               'upload_images' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/upload/profilepicture',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'imageupload',
                    ),
                ),
            ),
            
            'upload_audits' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/upload/audit',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'auditupload',
                    ),
                ),
            ),
            
            'upload_observations' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/upload/observation',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'observationupload',
                    ),
                ),
            ),
			
            'upload_client' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/upload/client',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action' => 'clientupload',
                    ),
                ),
            ),
			
             
            
        ),
    ),
 	
	'view_manager'	=> array(
        'strategies' => array(
             'ViewJsonStrategy',
             ),
		//'template_path_stack'	=> array(
		//	'Register'	=> __DIR__ . '/../view',
		//),
        
	),
	
	
);

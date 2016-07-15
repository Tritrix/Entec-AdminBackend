<?php
return array(
    
    
    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Users' => 'Users\Controller\UsersController',
            'Users\Controller\Appointments' => 'Users\Controller\AppointmentsController',
            'Users\Controller\Vitalrecords' => 'Users\Controller\VitalrecordsController',
            'Users\Controller\Groups' => 'Users\Controller\GroupsController',
            'Users\Controller\Authentication' => 'Users\Controller\AuthenticationController',
            'Users\Controller\Doctor' => 'Users\Controller\DoctorController',
            'Users\Controller\Message' => 'Users\Controller\MessageController',
            
        ),
    ),
	
    'router' => array(
        'routes' => array(

          //By default profile action is loaded
//            'users' => array(
//                'type'    => 'segment',
//                'options' => array(
//                    'route'    => '/api/v1/users[/:id]',
//                     'constraints' => array(
//                            'id' => '[0-9]+',
//                         ),
//                    'defaults' => array(
//                        'controller' => 'Users\Controller\Users',
//                        'action' => 'profile',
//                    ),
//                ),
//				'may_terminate' => true,
//            ),
            
            
             'users' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users[/:id]',
                     'constraints' => array(
                            'id' => '[0-9]+',
                         ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Users',
                        'action' => 'profile',
                    ),
                ),
				'may_terminate' => true,
            ),
            
            
             'state' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/state[/:id]',
                     'constraints' => array(
                            'id' => '[0-9]+',
                         ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Users',
                        'action' => 'state',
                    ),
                ),
				'may_terminate' => true,
            ),
            
            
             'city' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/city[/:id]',
                     'constraints' => array(
                            'id' => '[0-9]+',
                         ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Users',
                        'action' => 'city',
                    ),
                ),
				'may_terminate' => true,
            ),
            
            
            
            'country' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/country',
                     'constraints' => array(
                            'id' => '[0-9]+',
                         ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Users',
                        'action' => 'country',
                    ),
                ),
				'may_terminate' => true,
            ),
            
            
            'message' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/message',
                     'constraints' => array(
                            'id' => '[0-9]+',
                         ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Message',
                        'action' => 'message',
                    ),
                ),
				'may_terminate' => true,
            ),
            
            
            
            'inbox' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/[:id]/message/inbox',
                     'constraints' => array(
                            'id' => '[0-9]+',
                         ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Message',
                        'action' => 'inbox',
                    ),
                ),
				'may_terminate' => true,
            ),
            
            
            
            'outbox' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/[:id]/message/outbox',
                     'constraints' => array(
                            'id' => '[0-9]+',
                         ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Message',
                        'action' => 'outbox',
                    ),
                ),
				'may_terminate' => true,
            ),
            
            
             'archive' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/[:id]/message/archive',
                     'constraints' => array(
                            'id' => '[0-9]+',
                         ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Message',
                        'action' => 'archive',
                    ),
                ),
				'may_terminate' => true,
            ),
            
            'delete' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/users/[:id]/message/delete',
                     'constraints' => array(
                            'id' => '[0-9]+',
                         ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Message',
                        'action' => 'delete',
                    ),
                ),
				'may_terminate' => true,
            ),
            
            
            
            'finddoctor' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/v1/finddoctor',
                     'constraints' => array(
                            'id' => '[0-9]+',
                         ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Doctor',
                        'action' => 'finddoctor',
                    ),
                ),
				'may_terminate' => true,
            ),
         
            
            
            
            
          
            
        ),
    ),
	
	'view_manager'	=> array(
        'strategies' => array(
             'ViewJsonStrategy',
             ),
	),
	
	
	
);

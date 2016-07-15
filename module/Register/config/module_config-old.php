<?php
return array(

	'controllers'	=> array(
		'invokables'	=> array(
			'Register\Controller\Register'	=>	'Register\Controller\RegisterController',
		),
	),
	
	// The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
		
		
            'register' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/register[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Register\Controller\Register',
                        'action'     => 'index',
                    ),
                ),
            ),
			
			
			 'doctor' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/doctor[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'doctor\Controller\doctor',
                        'action'     => 'index',
                    ),
                ),
		
            ),
			
			'patient' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/patient[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'patient\Controller\patient',
                        'action'     => 'index',
                    ),
                ),
		
            ),
			
			'lab' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/lab[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'lab\Controller\lab',
                        'action'     => 'index',
                    ),
                ),
		
            ),
			
			
			'pharmacy' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/pharmacy[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'pharmacy\Controller\pharmacy',
                        'action'     => 'index',
                    ),
                ),
		
            ),
			
			
			
        ),
    ),
	
	'view_manager'	=> array(
       
		'template_path_stack'	=> array(
			'Register'	=> __DIR__ . '/../view',
		),
        
	),
	
	
	
	

);
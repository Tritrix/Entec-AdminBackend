<?php
namespace Register;

class Module
{
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php',
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}
	
	
	public function getConfig()
	{
		return include __DIR__ . '/config/module_config.php'; 
	}
	
	
	
	// Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Register\Model\RegisterTable' =>  function($sm) {
                    $tableGateway = $sm->get('RegisterTableGateway');
                    $table = new RegisterTable($tableGateway);
                    return $table;
                },
                'RegisterTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Register());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
	
	
	
	
	
	
}
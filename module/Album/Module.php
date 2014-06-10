<?php

//Module manager looks for this Module.php file and calls getAutoloaderConfig() and getConfig() automattically

namespace Album;
//add these for tablegateway stuff
use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getAutoloaderConfig()
    {
    	//returns array compatible with ZF2's AutoloaderFactory, we configure it so that we add a class map file to the ClassmapAutoloader
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        	//add this modules namespace to the StandardAutoloader
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
    	//loads config/module.config.php file
        return include __DIR__ . '/config/module.config.php';
    }
    
    
//     in order to always use the same instance of our AlbumTable, we will use the ServiceManager to define how to create one
//     This is most easily done I the Module class where we create a method called getServiceConfig() which is automatically called
//     by the ModuleManager and appliced to  the ServiceManager.  We'll then be able to retrieve the controller when we need it.
//     to configure the ServiceManager we can either supply the name of the class to be instantiated or a factory(closure or callback) that
//     instantiates the object when the ServiceManager needs it.  We start by implementing getServiceConfig() to provide a factory that creates
//     an AlbumTable

    public function getServiceConfig()
    {
    	//returns and array of factories that are all merged together by the ModuleManager before passing to the ServiceManager
    	return array(
    			'factories' => array(
    					//use the ServiceManager to create an AlbumTableGateway to pass to the AlbumTable
    					'Album\Model\AlbumTable' =>  function($sm) {
    						$tableGateway = $sm->get('AlbumTableGateway');
    						$table = new AlbumTable($tableGateway);
    						return $table;
    					},
    					//tell the ServiceManager that an AlbumTableGateway is created by getting a Zend\Db\Adapter\Adapter
    					'AlbumTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Album());
    						return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    	);
    }
}


<?php
return array(
	//provides a list of all the controllers provided by the module
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'album' => array(
                'type'    => 'segment',
                'options' => array(
                		// [ ] denotes optional
                    'route'    => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                	//the default action for the array controller should be the 'index' action
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
        	//add view directory to the TemplatePathStack configuration
        	//this allows it to find the vew scripts for the Album module that are stored in the view directory
            'album' => __DIR__ . '/../view',
        ),
    ),
);
<?php 
return array(
     'controllers' => array(
         'invokables' => array(
             'Campaign\Controller\Campaign' => 'Campaign\Controller\CampaignController',
         ),
     ),

     'router' => array(
        'router_class' => 'Zend\Mvc\Router\Http\TranslatorAwareTreeRouteStack',
         'routes' => array(
             'campaign' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '[/:lang]/campaign[/]',
                     'constraints' => array(
                        'lang' => '[a-z]{2}(-[A-Z]{2}){0,1}'
                    ),
                     'defaults' => array(
                         'controller' => 'Campaign\Controller\Campaign',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'campaign' => __DIR__ . '/../view',
         ),
     ),
 );
 ?>
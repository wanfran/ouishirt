<?php 
return array(
     'controllers' => array(
         'invokables' => array(
             'Campaign\Controller\Campaign' => 'Campaign\Controller\CampaignController',
         ),
     ),

     'router' => array(
         'routes' => array(
             'album' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/campaign[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
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
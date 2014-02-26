<?php 
return array(
     'controllers' => array(
         'invokables' => array(
             'Campaign\Controller\Campaign' => 'Campaign\Controller\CampaignController',
         ),
     ),

     'router' => array(
         'routes' => array(
             'campaign' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/campaign[/]',
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
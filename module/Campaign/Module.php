<?php 

namespace Campaign;

use Campaign\Model\Campaign;
use Campaign\Model\CampaignTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

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
         return include __DIR__ . '/config/module.config.php';
     }

     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Campaign\Model\CampaignTable' =>  function($sm) {
                     $tableGateway = $sm->get('CampaignTableGateway');
                     $table = new CampaignTable($tableGateway);
                     return $table;
                 },
                 'CampaignTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Campaign());
                     return new TableGateway('campaign', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }
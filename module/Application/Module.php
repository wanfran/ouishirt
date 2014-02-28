<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

// Add this for Table Date Gateway
use Application\Model\Auth;
use Application\Model\UsersTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
// Add this for SMTP transport
use Zend\ServiceManager\ServiceManager;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        // Register a render event
        //$app = $e->getParam('application');
        //$app->getEventManager()->attach('render', array($this, 'setLayoutTitle'));
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                // For Yable data Gateway
                'Application\Model\UsersTable' =>  function($sm) {
                    $tableGateway = $sm->get('UsersTableGateway');
                    $table = new UsersTable($tableGateway);
                    return $table;
                },
                'UsersTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Auth()); // Notice what is set here
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                // Add this for SMTP transport
                'mail.transport' => function (ServiceManager $serviceManager) {
                    $config = $serviceManager->get('Config'); 
                    $transport = new Smtp();                
                    $transport->setOptions(new SmtpOptions($config['mail']['transport']['options']));
                    return $transport;
                },
            ),
        );
    }

    public function setLayoutTitle($e)
    {
        $matches    = $e->getRouteMatch();
        $action     = ucfirst($matches->getParam('action'));
        $controller = $matches->getParam('controller');
        $module     = __NAMESPACE__;
        $siteName   = 'OuiShirt';

        // Getting the view helper manager from the application service manager
        $viewHelperManager = $e->getApplication()->getServiceManager()->get('viewHelperManager');

        // Getting the headTitle helper from the view helper manager
        $headTitleHelper   = $viewHelperManager->get('headTitle');

        // Setting a separator string for segments
        $headTitleHelper->setSeparator(' - ');

        // Setting the action, controller, module and site name as title segments
        $headTitleHelper->append($action);
        //$headTitleHelper->append($controller);
        //$headTitleHelper->append($module);
        $headTitleHelper->append($siteName);
    }
}

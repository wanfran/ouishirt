<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
       
        // Register a render event
        //$app = $e->getParam('application');
        //$app->getEventManager()->attach('render', array($this, 'setLayoutTitle'));

        




        $session = $e->getApplication()->getServiceManager()->get('session');
        if (isset($session->lang)) {
            $translator = $e->getApplication()->getServiceManager()->get('translator');
            $translator->setLocale($session->lang);

            $viewModel = $e->getViewModel();
            $viewModel->lang_ = $session->lang_;
            $viewModel->lang = substr($session->lang, 0, 2);
        }

        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('route', function ($e) {
            $lang = $e->getRouteMatch()->getParam('lang');

            // If there is no lang parameter in the route, nothing to do
            if (empty($lang)) {
                return;
            }

            $services = $e->getApplication()->getServiceManager();

            // If the session language is the same, nothing to do
            $session = $services->get('session');
            if (isset($session->lang) && ($session->lang == $lang)) {
                return;
            }

            $viewModel  = $e->getViewModel();
            $translator = $services->get('translator');

            $viewModel->lang = $lang;
            $session->lang = $lang;
            switch ($lang) {
                case 'fr':
                    $lang = 'fr_FR';
                    break;
                case 'en':
                    $lang = 'en_US';
                    break;
                case 'de':
                    $lang = 'de_DE';
                    break;
                case 'nl':
                    $lang = 'nl_NL';
                    break;
                default:
                    $lang = 'fr_FR';
                    break;
            };
            $viewModel->lang_ = $lang;
            $translator->setLocale($lang);
            // Attach the translator to the router
            $e->getRouter()->setTranslator($translator);
            $session->lang_ = $lang;
        }, -10);
        
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

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

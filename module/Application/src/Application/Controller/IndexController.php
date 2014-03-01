<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{


    public function indexAction()
    {
		$view = new ViewModel();
		return $view ;
    }


    public function loginAction()
    {
    	$form = new AuthForm();
    	// $form->get('submit')->setValue('Login');

    	$request = $this->getRequest();
    	if ($request->isPost()) {
			$authFormFilters = new Auth();
			$form->setInputFilter($authFormFilters->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				$sm = $this->getServiceLocator();
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

				$config = $this->getServiceLocator()->get('Config');
				$staticSalt = $config['static_salt'];

				$authAdapter = new AuthAdapter($dbAdapter,
										   'users', // there is a method setTableName to do the same
										   'user_name', // there is a method setIdentityColumn to do the same
										   'user_password', // there is a method setCredentialColumn to do the same
										   "MD5(CONCAT('$staticSalt', ?, user_password_salt)) AND usr_active = 1" // setCredentialTreatment(parametrized string) 'MD5(?)'
										  );
				$authAdapter
					->setIdentity($data['user_name'])
					->setCredential($data['user_password'])
				;

				$auth = new AuthenticationService();
				$result = $auth->authenticate($authAdapter);

				switch ($result->getCode()) {
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						// do stuff for nonexistent identity
						break;

					case Result::FAILURE_CREDENTIAL_INVALID:
						// do stuff for invalid credential
						break;

					case Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(
							null,
							'user_password'
						));
						$time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
//						if ($data['rememberme']) $storage->getSession()->getManager()->rememberMe($time); // no way to get the session
						if ($data['rememberme']) {
							$sessionManager = new \Zend\Session\SessionManager();
							$sessionManager->rememberMe($time);
						}
						break;

					default:
						// do stuff for other failure
						break;
				}
				foreach ($result->getMessages() as $message) {
					$messages .= "$message\n"; 
				}
			}
		}
		return new ViewModel(array('form' => $form, 'messages' => $messages));
    }


    public function logoutAction()
	{
		$auth = new AuthenticationService();
		// or prepare in the globa.config.php and get it from there
		// $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
		}			
		
		$auth->clearIdentity();
//		$auth->getStorage()->session->getManager()->forgetMe(); // no way to get the sessionmanager from storage
		$sessionManager = new \Zend\Session\SessionManager();
		$sessionManager->forgetMe();
		
		return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'login'));		
	}	


}

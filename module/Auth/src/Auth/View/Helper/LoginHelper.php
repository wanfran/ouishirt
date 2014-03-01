<?php 

namespace Auth\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Auth\Controller\IndexController;
 
class LoginHelper extends AbstractHelper
{
    public function __invoke()
    {
        $loginController = new IndexController();
        $loginController->loginAction();

    }
}
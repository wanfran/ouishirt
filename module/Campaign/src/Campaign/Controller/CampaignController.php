<?php 
namespace Campaign\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Campaign\Model\Campaign;          
use Campaign\Form\CampaignForm;       

class CampaignController extends AbstractActionController
{
    protected $campaignTable;

    public function indexAction()
    {
//      return new ViewModel(array(
//          'campaigns' => $this->getCampaignTable()->fetchAll(),
//      ));
    }

     public function addAction()
     {
       
     }

     public function editAction()
     {
        
     }

     public function deleteAction()
     {
       
     }

     public function getAlbumTable()
     {
       
     }
 }
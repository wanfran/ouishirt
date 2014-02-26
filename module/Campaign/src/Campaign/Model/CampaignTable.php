<?php

namespace Campaign\Model;

 use Zend\Db\TableGateway\TableGateway;

 class CampaignTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getCampaign($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveCampaign(Campaign $campaign)
     {
         $data = array(
             'artist' => $campaign->artist,
             'title'  => $campaign->title,
         );

         $id = (int) $campaign->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getCampaign($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Campaign id does not exist');
             }
         }
     }

     public function deleteCampaign($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
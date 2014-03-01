<?php
namespace Auth\Model;

use Zend\Db\TableGateway\TableGateway;

class UsersTable
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

    public function getUser($user_id)
    {
        $user_id  = (int) $user_id;
        $rowset = $this->tableGateway->select(array('user_id' => $user_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

	public function getUserByToken($token)
    {
        $rowset = $this->tableGateway->select(array('user_registration_token' => $token));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $token");
        }
        return $row;
    }
	
    public function activateUser($user_id)
    {
		$data['user_active'] = 1;
		$data['user_email_confirmed'] = 1;
		$this->tableGateway->update($data, array('user_id' => (int)$user_id));
    }	

    public function getUserByEmail($user_email)
    {
        $rowset = $this->tableGateway->select(array('user_email' => $user_email));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $user_email");
        }
        return $row;
    }

    public function changePassword($user_id, $password)
    {
		$data['password'] = $password;
		$this->tableGateway->update($data, array('user_id' => (int)$user_id));
    }
	
    public function saveUser(Auth $auth)
    {
		// for Zend\Db\TableGateway\TableGateway we need the data in array not object
        $data = array(
            'user_name' 				=> $auth->user_name,
            'user_password'  		=> $auth->user_password,
            'user_email'  			=> $auth->user_email,
            'userl_id'  				=> $auth->userl_id,
            'lng_id'  				=> $auth->lng_id,
            'user_active'  			=> $auth->user_active,
            'user_question'  		=> $auth->user_question,
            'user_answer'  			=> $auth->user_answer,
            'user_picture'  			=> $auth->user_picture,
            'user_password_salt' 	=> $auth->user_password_salt,
            'user_registration_date' => $auth->user_registration_date,
            'user_registration_token'=> $auth->user_registration_token,
			'user_email_confirmed'	=> $auth->user_email_confirmed,
        );
		// If there is a method getArrayCopy() defined in Auth you can simply call it.
		// $data = $auth->getArrayCopy();

        $user_id = (int)$auth->user_id;
        if ($user_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUser($user_id)) {
                $this->tableGateway->update($data, array('user_id' => $user_id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
	
    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('user_id' => $user_id));
    }	
}
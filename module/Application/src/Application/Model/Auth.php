<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
// the object will be hydrated by Zend\Db\TableGateway\TableGateway
class Auth implements InputFilterAwareInterface
{
    public $user_id;
    public $user_name;
    public $user_password;
    public $user_email;	
    public $userl_id;	
    public $lng_id;	
    public $user_active;	
    public $user_question;	
    public $user_answer;	
    public $user_picture;	
    public $user_password_salt;
    public $user_registration_date;
    public $user_registration_token;	
    public $user_email_confirmed;	

	// Hydration
	// ArrayObject, or at least implement exchangeArray. For Zend\Db\ResultSet\ResultSet to work
    public function exchangeArray($data) 
    {
        $this->user_id     = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->user_name = (!empty($data['user_name'])) ? $data['user_name'] : null;
        $this->user_password = (!empty($data['user_password'])) ? $data['user_password'] : null;
        $this->user_email = (!empty($data['user_email'])) ? $data['user_email'] : null;
        $this->userl_id = (!empty($data['userl_id'])) ? $data['userl_id'] : null;
        $this->lng_id = (!empty($data['lng_id'])) ? $data['lng_id'] : null;
        $this->user_active = (isset($data['user_active'])) ? $data['user_active'] : null;
        $this->user_question = (!empty($data['user_question'])) ? $data['user_question'] : null;
        $this->user_answer = (!empty($data['user_answer'])) ? $data['user_answer'] : null;
        $this->user_picture = (!empty($data['user_picture'])) ? $data['user_picture'] : null;
        $this->user_password_salt = (!empty($data['user_password_salt'])) ? $data['user_password_salt'] : null;
        $this->user_registration_date = (!empty($data['user_registration_date'])) ? $data['user_registration_date'] : null;
        $this->user_registration_token = (!empty($data['user_registration_token'])) ? $data['user_registration_token'] : null;
        $this->user_email_confirmed = (isset($data['user_email_confirmed'])) ? $data['user_email_confirmed'] : null;
    }	

	// Extraction. The Registration from the tutorial works even without it.
	// The standard Hydrator of the Form expects getArrayCopy to be able to bind
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
	
	
	protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
	
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'user_name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'user_password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }	
}
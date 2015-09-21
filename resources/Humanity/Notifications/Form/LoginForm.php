<?php
namespace Humanity\Notifications\Form;

use Incoded\Core\Form\Form;
use Incoded\Core\Form\Field\InputText;
use Incoded\Core\Form\Field\InputHidden;

use Incoded\Core\Database\DBLayer;

use Incoded\Notification\Database\Model\UserModel;

class LoginForm extends Form
{
    private $db;

    public $user_account;

    public function init()
    {
        $this->db = new DBLayer();

        $this->setFields(array(
            'email'     => new InputText('email'),
            'password'  => new InputText('password'),
        ));
    }

    public function isValid()
    {
        if (!parent::isValid()) {
            return false;
        }

        $values = $this->getValues();

        if (!isset($values['email']) || $values['email'] == '' || !$this->isEmail($values['email'])) {
            $this->setError('email', 'This field is required and has to be email (e.g. john.doe@example.org).');
        }

        if (!isset($values['password']) || $values['password'] == '') {
            $this->setError('password', 'This field is required.');
        }

        // get user from database
        $this->db->select()
            ->table('user')
            ->where('username = "' . $values['email'] . '" AND is_active = 1')
            ->execute();

        $this->user_account = $this->db->fetch();

        if (!$this->user_account) {
            $this->setError('_global_', 'User not found.');
        }

        return !$this->hasErrors();
    }

    public function getUserAccount()
    {
        return $this->user_account;
    }

    private function isEmail($value = '')
    {
        if (!preg_match( "/^(([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+))*$/", $value))
        {
            return false;
        }
        
        return true;
    }
}
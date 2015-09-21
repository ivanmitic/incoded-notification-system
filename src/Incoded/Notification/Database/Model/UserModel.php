<?php
namespace Incoded\Notification\Database\Model;

use Incoded\Core\Database\Model;

class UserModel extends Model
{
    public function init()
    {
        $this->setTable('user');

        $this->setPk('id');

        $this->setColumns(array(
            'id',
            'user_type_id',
            'username',
            'password',
            'is_active',
            'created_at',
            'updated_at',
        ));
    }
}
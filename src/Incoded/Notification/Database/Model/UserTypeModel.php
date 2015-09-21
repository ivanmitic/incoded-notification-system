<?php
namespace Incoded\Notification\Database\Model;

use Incoded\Core\Database\Model;

class UserTypeModel extends Model
{
    public function init()
    {
        $this->setTable('user_type');

        $this->setPk('id');

        $this->setColumns(array(
            'id',
            'name',
            'created_at',
            'updated_at',
        ));
    }
}
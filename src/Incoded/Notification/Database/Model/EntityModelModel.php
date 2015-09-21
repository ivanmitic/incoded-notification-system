<?php
namespace Incoded\Notification\Database\Model;

use Incoded\Core\Database\Model;

class EntityModelModel extends Model
{
    public function init()
    {
        $this->setTable('entity_model');

        $this->setPk('id');

        $this->setColumns(array(
            'id',
            'code',
            'model',
            'type',
            'created_at',
            'updated_at',
        ));
    }
}
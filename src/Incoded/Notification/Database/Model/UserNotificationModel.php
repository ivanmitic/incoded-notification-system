<?php
namespace Incoded\Notification\Database\Model;

use Incoded\Core\Database\Model;

class UserNotificationModel extends Model
{
    public function init()
    {
        $this->setTable('user_notification');

        $this->setPk('id');

        $this->setColumns(array(
            'id',
            'user_id',
            'notification_id',
            'entity_id',
            'title',
            'body',
            'is_read',
            'created_at',
            'updated_at',
        ));
    }
}
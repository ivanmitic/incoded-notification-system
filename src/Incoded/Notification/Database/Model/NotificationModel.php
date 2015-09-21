<?php
namespace Incoded\Notification\Database\Model;

use Incoded\Core\Database\Model;

/**
 * This class represents a model of a notification from database.
 *
 * @author Ivan Mitic <ivan.mitic@gmail.com>
 */
class NotificationModel extends Model
{
    /**
     * Sets up the model
     */
    public function init()
    {
        $this->setTable('notification');

        $this->setPk('id');

        $this->setColumns(array(
            'id',
            'entity_model_id',
            'code',
            'title',
            'body',
            'created_at',
            'updated_at',
        ));
    }
}
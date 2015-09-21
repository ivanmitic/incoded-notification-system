<?php
namespace Incoded\Notification\Database\Collection;

use Incoded\Core\Database\Collection;
use Incoded\Notification\Database\Model\NotificationModel;

/**
 * This class represents a collection of notification models.
 *
 * @author Ivan Mitic <ivan.mitic@gmail.com>
 */
class NotificationCollection extends Collection
{
    /**
     * Sets up the collection
     */
    public function init()
    {
        $this->setModel(new NotificationModel());
    }
}
<?php
namespace Incoded\Notification\Database\Collection;

use Incoded\Core\Database\Collection;
use Incoded\Notification\Database\Model\UserNotificationModel;

class UserNotificationCollection extends Collection
{
    public function init()
    {
        $this->setModel(new UserNotificationModel());
    }
}
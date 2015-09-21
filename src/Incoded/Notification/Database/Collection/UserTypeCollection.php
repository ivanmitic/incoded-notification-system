<?php
namespace Incoded\Notification\Database\Collection;

use Incoded\Core\Database\Collection;
use Incoded\Notification\Database\Model\UserTypeModel;

class UserTypeCollection extends Collection
{
    public function init()
    {
        $this->setModel(new UserTypeModel());
    }
}
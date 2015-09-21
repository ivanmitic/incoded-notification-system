<?php
namespace Incoded\Notification\Database\Collection;

use Incoded\Core\Database\Collection;
use Incoded\Notification\Database\Model\EntityModelModel;

class EntityModelCollection extends Collection
{
    public function init()
    {
        $this->setModel(new EntityModelModel());
    }
}
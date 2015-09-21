<?php
namespace Incoded\Notification\Form;

use Incoded\Core\Form\Form;
use Incoded\Core\Form\Field\InputHidden;
use Incoded\Core\Form\Field\InputText;
use Incoded\Core\Form\Field\Textarea;
use Incoded\Core\Form\Field\Select;

use Incoded\Notification\Database\Collection\EntityModelCollection;
use Incoded\Notification\Database\Collection\UserTypeCollection;

class NotificationForm extends Form
{
    public function init()
    {
        // get entities
        $entity_model_collection    = new EntityModelCollection();
        $entity_models              = $entity_model_collection->getModels();
        $data_entities              = array();

        foreach ($entity_models as $entity_model)
        {
            $values = $entity_model->getValues();

            if ($values['type'] == 'data') {
                $data_entities[ $values['id'] ] = $values['code'];
            }
            else {
                $service_entities[ $values['id'] ] = $values['code'];
            }
        }

        // get user types
        $user_type_collection   = new UserTypeCollection();
        $user_type_models       = $user_type_collection->getModels();
        $user_types             = array();

        foreach ($user_type_models as $user_type_model)
        {
            $values = $user_type_model->getValues();

            $user_types[ $values['id'] ] = $values['name'];
        }

        // set fields
        $this->setFields(array(
            'entity_data_id'    => new Select('entity_model_id', '', $data_entities),
            'entity_service_id' => new Select('entity_model_id', '', $service_entities, array('multiple' => 'multiple')),
            'user_type_id'      => new Select('user_type_id', '', $user_types, array('multiple' => 'multiple')),
            'code'              => new InputText('code'),
            'title'             => new InputText('title'),
            'body'              => new Textarea('body'),
        ));
    }

    public function isValid()
    {
        if (!parent::isValid()) {
            return false;
        }

        return true;
    }
}
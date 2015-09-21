<?php
namespace Incoded\Notification\Form;

use Incoded\Core\Form\Form;
use Incoded\Core\Form\Field\InputHidden;
use Incoded\Core\Form\Field\InputText;
use Incoded\Core\Form\Field\Textarea;
use Incoded\Core\Form\Field\Select;

use Incoded\Core\Database\DBLayer;

use Incoded\Notification\Database\Collection\EntityModelCollection;
use Incoded\Notification\Database\Collection\UserTypeCollection;

class NotificationSettingForm extends Form
{
    public $user_type_id;

    public function init()
    {
        $query = "
SELECT 
    `notification`.`id`, `notification`.`code`, `notification_service`.`entity_model_id`, `entity_model`.`code` AS entity_code
FROM 
    `notification` 
    JOIN `notification_user_type` ON `notification`.`id` = `notification_user_type`.`notification_id`
    JOIN `notification_service` ON `notification`.`id` = `notification_service`.`notification_id`
    JOIN `entity_model` ON `notification_service`.`entity_model_id` = `entity_model`.`id`
WHERE
    `notification_user_type`.`user_type_id` = 2
ORDER BY
    `notification`.`id` 
;
";
        $db = new DBLayer();
        $db->select("`notification`.`id`, `notification`.`code`, `notification_service`.`entity_model_id`, `entity_model`.`code` AS entity_code")
            ->table("
`notification` 
JOIN `notification_user_type` ON `notification`.`id` = `notification_user_type`.`notification_id`
JOIN `notification_service` ON `notification`.`id` = `notification_service`.`notification_id`
JOIN `entity_model` ON `notification_service`.`entity_model_id` = `entity_model`.`id`")
            ->where("`notification_user_type`.`user_type_id` = 2")
            ->execute();

        $notifications = $db->fetchAll();

        echo '<pre>' . print_r($notifications, true) . '</pre>';

        $fields = array();

        foreach ($notifications as $notification)
        {
            $fields[  ]
        }

/*
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
*/
    }

    public function isValid()
    {
        if (!parent::isValid()) {
            return false;
        }

        return true;
    }

    public function setUserTypeId($user_type_id)
    {
        $this->user_type_id = $user_type_id;
    }

    public function getUserTypeId()
    {
        return $this->user_type_id;
    }
}
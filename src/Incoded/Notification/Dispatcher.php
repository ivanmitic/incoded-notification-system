<?php
namespace Incoded\Notification;

use Incoded\Core\Database\DBLayer;

use Incoded\Notification\Service\EmailService as EmailService;
use Incoded\Notification\Service\PushService;
use Incoded\Notification\Service\SmsService;

use Incoded\Notification\Database\Model\UserNotificationModel;

class Dispatcher
{
    private static $db;

    private static $service_namespace = 'Incoded\Notification\Service\\';

    public function __construct()
    {
        self::$db = new DBLayer();
    }

    /**
     * Sending notification
     */
    public static function release($user_id, $notification_code, $post_id)
    {
        new self();

        $users = self::load($user_id, $notification_code, $post_id);

        // echo '<pre>' . print_r($users, true) . '</pre>';

        foreach ($users as $user)
        {
            // save notification in database
            $notification = new UserNotificationModel();
            $notification->setValues(array(
                'user_id'         => $user['id'],
                'notification_id' => $user['notification_id'],
                'entity_id'       => $post_id,
                'title'           => $user['title'],
                'body'            => $user['body'],
            ));
            $notification->save();

            // send notification via service
            foreach ($user['services'] as $service_class)
            {
                $service_class = self::$service_namespace . $service_class;
                $service       = new $service_class();
                // $service->release();
            }
        }

    }

    /**
     * Returns users that should recieve notification, notification properties and services
     */
    public static function load($user_id, $notification_code, $post_id)
    {
        self::$db->select("`user`.*, `notification`.`id` AS notification_id, `notification`.`title`, `notification`.`body`, `entity_model`.`model` AS service")
            ->table("`user`
JOIN `user_type` ON `user`.`user_type_id` = `user_type`.`id`
JOIN `notification_user_type` ON `user_type`.`id` = `notification_user_type`.`user_type_id`
JOIN `notification` ON `notification_user_type`.`notification_id` = `notification`.`id`
JOIN `user_notification_service` ON `notification`.`id` = `user_notification_service`.`notification_id`
JOIN `entity_model` ON `user_notification_service`.`entity_model_id` = `entity_model`.`id`")
            ->where("`notification`.`code` = '" . $notification_code . "' AND `entity_model`.`type` = 'service' AND `user`.`id` != " . $user_id)
            ->order("`user`.`id`")
            ->execute();

        $values = self::$db->fetchAll();

        // echo '<pre>' . print_r($values, true) . '</pre>';

        $users = array();

        foreach ($values as $value)
        {
            if ( !isset($users[$value['id']]) ) {

                $users[$value['id']] = array(
                    'id'              => $value['id'],
                    'notification_id' => $value['notification_id'],
                    'username'        => $value['username'],
                    'title'           => $value['title'],
                    'body'            => $value['body'],
                    'services'        => array($value['service']),
                );

            }
            else {

                $users[$value['id']]['services'][] = $value['service'];

            }
        }

        return $users;
    }
}
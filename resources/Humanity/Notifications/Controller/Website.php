<?php
namespace Humanity\Notifications\Controller;

use Incoded\Core\Controller\Controller;
use Incoded\Core\Request\Request;

use Humanity\Notifications\Form\LoginForm;

use Incoded\Notification\Database\Collection\NotificationCollection;
use Incoded\Notification\Database\Collection\UserNotificationCollection;
use Incoded\Notification\Database\Model\NotificationModel;
use Incoded\Notification\Form\NotificationForm;
use Incoded\Notification\Form\NotificationSettingForm;

use Incoded\Notification\Dispatcher as NotificationDispatcher;

class Website extends Controller
{
    private $is_auth;

    private $user_id;

    private $user_type;

    /**
     * Executes before any other method
     *
     * @param object Request $request A Request class instance
     */
    public function __before(Request $request)
    {
        $router  = $this->getModel()->router;
        $session = $this->getModel()->session;
        $db      = $this->getModel()->dblayer;

        // echo '<pre>' . $session->get('_is_auth') . '</pre>';
        // echo '<pre>' . $session->get('_user_id') . '</pre>';

        $is_auth   = $session->get('_is_auth');
        $user_id   = $session->get('_user_id');
        $user_type = null;

        if ($is_auth && $user_id) {
            // get user from database
            $db->select()
                ->table('user')
                ->where('id = ' . $user_id)
                ->execute();

            $user = $db->fetch();

            // get user type from database
            $db->select()
                ->table('user_type')
                ->where('id = ' . $user['user_type_id'])
                ->execute();

            $user_type = $db->fetch();
            $user_type = $user_type['name'];
        }

        $this->is_auth   = $is_auth;
        $this->user_id   = $user_id;
        $this->user_type = $user_type;

        $this->view->is_auth   = $is_auth;
        $this->view->user_type = $user_type;
        $this->view->action    = $router->getMethod();
    }

    /**
     * index method shows the home page content
     *
     * @param object Request $request A Request class instance
     */
    public function index(Request $request)
    {
        $this->show('index');
    }

    /**
     * login method shows login page and logs in user
     *
     * @param object Request $request A Request class instance
     */
    public function login(Request $request)
    {
        $session    = $this->getModel()->session;
        $router     = $this->getModel()->router;
        $form       = new LoginForm();

        if ('POST' === $request->getMethod()) {

            $form->setValues(array(
                'csrf_token'    => $request->post('csrf_token'),
                'email'         => $request->post('email'),
                'password'      => $request->post('password'),
            ));

            if ($form->isValid()) {
                // user authentification
                $user_account = $form->getUserAccount();

                $session->set('_is_auth', TRUE);
                $session->set('_user_id', $user_account['id']);

                $router->redirect('notifications');
            }
        }

        $this->form = $form;

        $this->show('login');
    }

    /**
     * logout method logs out users
     *
     * @param object Request $request A Request class instance
     */
    public function logout(Request $request)
    {
        $router  = $this->getModel()->router;
        $session = $this->getModel()->session;

        $session->remove('_is_auth');
        $session->remove('_user_id');

        $router->redirect('');
    }

    /**
     * notifications method selects user's notifications from database
     * and shows them on the page
     *
     * @param object Request $request A Request class instance
     */
    public function notifications(Request $request)
    {
        $session = $this->getModel()->session;
        $router  = $this->getModel()->router;

        $is_auth = $session->get('_is_auth');
        $user_id = $session->get('_user_id');

        if ( !$is_auth || !$user_id ) {
            $router->redirect('404');
        }

        // get user notifications from database
        $notifications = new UserNotificationCollection();

        $this->notifications = $notifications->getModels();

        $this->show('notifications');
    }

    /**
     * settings method shows user settings form where user will choose
     * which notifications will recieve and which way
     *
     * @param object Request $request A Request class instance
     */
    public function settings(Request $request)
    {
        $session = $this->getModel()->session;
        $router  = $this->getModel()->router;

        $is_auth = $session->get('_is_auth');
        $user_id = $session->get('_user_id');

        if ( !$is_auth || !$user_id ) {
            $router->redirect('404');
        }

        // $form = new NotificationSettingForm();
        // $this->form = $form;

        $db = $this->getModel()->dblayer;
        $db->select("`notification`.`id`, `notification`.`code`, `notification_service`.`entity_model_id`, `entity_model`.`code` AS entity_code")
            ->table("
`notification` 
JOIN `notification_user_type` ON `notification`.`id` = `notification_user_type`.`notification_id`
JOIN `notification_service` ON `notification`.`id` = `notification_service`.`notification_id`
JOIN `entity_model` ON `notification_service`.`entity_model_id` = `entity_model`.`id`")
            ->where("`notification_user_type`.`user_type_id` = 2")
            ->order("`notification`.`id`")
            ->execute();

        $values = $db->fetchAll();

        // echo '<pre>' . print_r($values, true) . '</pre>';

        $notifications = array();

        foreach ($values as $value)
        {
            if ( !isset($notifications[$value['id']]) ) {

                $notifications[$value['id']] = array(
                    'code'     => $value['code'],
                    'services' => array(
                        $value['entity_model_id'] => $value['entity_code']
                    ),
                );

            } else {

                $notifications[$value['id']]['services'][$value['entity_model_id']] = $value['entity_code'];

            }
        }

        // echo '<pre>' . print_r($notifications, true) . '</pre>';

        $this->notifications = $notifications;

        $this->show('settings');
    }

    /**
     * admin_notifications method selects notification patterns from database
     * and shows them on the page
     *
     * @param object Request $request A Request class instance
     */
    public function admin_notifications(Request $request)
    {
        // $this->view->addAsset('/css/additional.css', 'stylesheets');
        // $this->view->addAsset('/bundles/incodedfrontend/js/articles/articles.js', 'javascripts');

        $router = $this->getModel()->router;

        if ($this->user_type != 'admin') {
            // user has no credential to access this page
            $router->redirect('404');
        }

        // get notifications from database
        $notifications = new NotificationCollection();

        $this->notifications = $notifications->getModels();
        $this->success = false;

        $this->show('admin/notifications');
    }

    /**
     * admin_notifications_new method shows the form and inserts
     * a new notification pattern in database
     *
     * @param object Request $request A Request class instance
     */
    public function admin_notifications_new(Request $request)
    {
        // $this->view->addAsset('/bundles/incodedfrontend/js/articles/create.js', 'javascripts');

        $session = $this->getModel()->session;
        $router  = $this->getModel()->router;

        if ($this->user_type != 'admin') {
            // user has no credential to access this page
            $router->redirect('404');
        }

        $form    = new NotificationForm();
        $success = false;

        if ('POST' === $request->getMethod()) {
            // get form values
            $form->setValues(array(
                'csrf_token'      => $request->post('csrf_token'),
                'entity_model_id' => $request->post('entity_model_id'),
                'code'            => $request->post('code'),
                'title'           => $request->post('title'),
                'body'            => $request->post('body'),
            ));

            // check if form is valid
            if ($form->isValid()) {
                // create new notification model
                $notification = new NotificationModel();
                $notification->setValues($form->getValues());
                $notification->save();

                // save notification code into the session
                $session->set('notification_created', $request->post('code'));

                // redirect to the list of notifications
                $router->redirect('admin_notifications');
            }
        }

        $this->form     = $form;
        $this->success  = $success;

        $this->show('admin/notifications_new');
    }

    /**
     * admin_notifications_edit method shows the form and updates
     * a new notification pattern in database
     *
     * @param object Request $request A Request class instance
     */
    public function admin_notifications_edit(Request $request)
    {
        $session = $this->getModel()->session;
        $router  = $this->getModel()->router;

        if ($this->user_type != 'admin') {
            // user has no credential to access this page
            $router->redirect('404');
        }

        $notification = new NotificationModel($request->get('id'));
        $form         = new NotificationForm($notification->getValues());
        $success      = false;

        if ('POST' === $request->getMethod()) {
            // get form values
            $form->setValues(array(
                'csrf_token'      => $request->post('csrf_token'),
                'entity_model_id' => $request->post('entity_model_id'),
                'code'            => $request->post('code'),
                'title'           => $request->post('title'),
                'body'            => $request->post('body'),
            ));

            // check if form is valid
            if ($form->isValid()) {
                // create new notification model
                $notification = new NotificationModel();
                $notification->setValues($form->getValues());
                $notification->save();

                // save notification code into the session
                $session->set('notification_created', $request->post('code'));

                // redirect to the list of notifications
                $router->redirect('admin_notifications');
            }
        }

        $this->notification_id = $request->get('id');
        $this->form            = $form;
        $this->success         = $success;

        $this->show('admin/notifications_edit');
    }

    /**
     * admin_notifications_delete method deletes notification
     * pattern from database
     *
     * @param object Request $request A Request class instance
     */
    public function admin_notifications_delete(Request $request)
    {
        $router = $this->getModel()->router;

        if ($this->user_type != 'admin') {
            // user has no credential to access this page
            $router->redirect('404');
        }

        // delete
        //$db->delete('id=1')->table('user')->execute();
    }

    /**
     * post_create method displays how to use notification
     * dispather to send notification to a user
     *
     * @param object Request $request A Request class instance
     */
    public function post_create(Request $request)
    {
        $router = $this->getModel()->router;

        if ($this->user_type != 'member') {
            // user has no credential to access this page
            $router->redirect('404');
        }

        // create post - save in database
        // ...

        $notification_code = 'post_created';
        $user_id           = $this->user_id;
        $post_id           = 1;

        // use notification dispather to release notification
        NotificationDispatcher::release($user_id, $notification_code, $post_id);

        $this->show('post/create');
    }
}
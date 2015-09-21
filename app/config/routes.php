<?php
return array(
    'login'         => array('uri' => '/login',       'controller' => 'website', 'method' => 'login'),
    'logout'        => array('uri' => '/logout',      'controller' => 'website', 'method' => 'logout'),
    'post_create'   => array('uri' => '/post/create', 'controller' => 'website', 'method' => 'post_create'),
    // admin & user
    'notifications' => array('uri' => '/notifications', 'controller' => 'website', 'method' => 'notifications'),
    'settings'      => array('uri' => '/settings',      'controller' => 'website', 'method' => 'settings'),
    // admin
    'admin_notifications'        => array('uri' => '/admin/notifications',            'controller' => 'website', 'method' => 'admin_notifications'),
    'admin_notifications_new'    => array('uri' => '/admin/notifications/new',        'controller' => 'website', 'method' => 'admin_notifications_new'),
    'admin_notifications_edit'   => array('uri' => '/admin/notifications/edit/:id',   'controller' => 'website', 'method' => 'admin_notifications_edit'),
    'admin_notifications_delete' => array('uri' => '/admin/notifications/delete/:id', 'controller' => 'website', 'method' => 'admin_notifications_delete'),
);

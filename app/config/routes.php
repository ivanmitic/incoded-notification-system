<?php
return array(
    'post_create'   => array('uri' => '/post/create', 'controller' => 'website', 'method' => 'post_create'),
    // admin
    'admin_notifications'        => array('uri' => '/admin/notifications',            'controller' => 'website', 'method' => 'admin_notifications'),
    'admin_notifications_new'    => array('uri' => '/admin/notifications/new',        'controller' => 'website', 'method' => 'admin_notifications_new'),
    'admin_notifications_edit'   => array('uri' => '/admin/notifications/edit/:id',   'controller' => 'website', 'method' => 'admin_notifications_edit'),
    'admin_notifications_delete' => array('uri' => '/admin/notifications/delete/:id', 'controller' => 'website', 'method' => 'admin_notifications_delete'),
);

<?php
namespace Incoded\Notification;

abstract class Service
{
    abstract public function release($reciever, $title, $body);
}
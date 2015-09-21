<?php
namespace Incoded\Core\Form\Validator;

class Email
{
    public function __construct($value = null)
    {
        return $this->is_valid($value);
    }

    public function is_valid($value = null)
    {
        if (!preg_match( "/^(([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+))*$/", $value))
        {
            return false;
        }
        
        return true;
    }
}
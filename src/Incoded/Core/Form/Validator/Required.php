<?php
namespace Incoded\Core\Form\Validator;

class Required
{
    private $value;
    private $message = 'This field is required.';

    public function __construct($value, $message = 'This field is required.')
    {
        $this->value   = $value;
        $this->message = $message;
    }

    public function is_valid()
    {
        if (is_array($this->value))
        {
            if (count($this->value) == 0) return false;
            
            $valid = true;

            foreach ($this->value as $c => $value)
            {
                $valid = $value != '' ? $valid : false;
            }

            return $valid != '' ? true : false;
        }
        
        return $this->value != '' ? true : false;
    }
}
<?php
namespace Incoded\Core\Form\Validator;

use Incoded\Core\Form\Validator\Required;
use Incoded\Core\Form\Validator\Email;

class Validator
{
    public function __construct()
    {

    }

    public function validate($fields, $filedsValidators, $form = null)
    {
        $container = array();

        if (!is_array($fields) || count($fields) == 0) return $container;
        if (!is_array($filedsValidators) || count($filedsValidators) == 0) return $container;

        $formName = $form !== null ? $form.'_' : '';

        foreach ($filedsValidators as $field => $validators)
        {
            // Set error if there is not field in validators array and it is required
            if (!array_key_exists($field, $fields) && array_key_exists('required', $validators))
            {
                $container[$formName.$field.'_error'] = $validators['required'];
            }

            if (array_key_exists($field, $fields) && count($validators) > 0)
            {
                $value = isset($fields[$field]) ? $fields[$field] : null;

                foreach ($validators as $validator => $message)
                {
                    $valid = call_user_func($validator.'Validator', $value);

                    if (!$valid && !isset($container[$formName.$field.'_error']))
                    {
                        $container[$formName.$field.'_error'] = $message;
                    }
                }
            }
        }

        return $container;
    }
}
?>
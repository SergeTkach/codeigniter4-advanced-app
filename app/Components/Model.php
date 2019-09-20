<?php

namespace App\Components;

abstract class Model extends \CodeIgniter\Model
{

    public static function findByPrimaryKey($id)
    {
        if (!$id)
        {
            return false;
        }

        $class = get_called_class();

        $model = new $class;

        return $model->find($id);
    }

    public function getFieldLabel(string $field)
    {
        if (!empty($this->validationRules[$field]['label']))
        {
            return $this->validationRules[$field]['label'];
        }

        return $field;
    }
    
    public function getFirstError()
    {
        $errors = $this->errors();

        $error = array_shift($errors);

        return $error;
    }

    public function saveUnprotected($data, &$error)
    {
        $this->protect(false);

        $return = $this->save($data);

        $this->protect(true);

        if (!$return)
        {
            $error = $this->getFirstError();
        }

        return $return;
    }    

}
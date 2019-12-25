<?php

namespace App\Cells;

abstract class BaseCell
{

    abstract public function cell(array $params = []) : string;

    public static function factory(array $params = [])
    {
        return view_cell(get_called_class() . '::cell', $params);
    }

    public function setParams(array $params = [])
    {
        foreach($params as $key => $value)
        {
            $this->$key = $value;
        }
    }

    public function render(string $view, array $params = []) : string
    {
        return view($view, $params, ['saveData' => false]);
    }

}
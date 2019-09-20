<?php

namespace App\Components;

abstract class Widget
{

    abstract function run();

    public function setParams(array $params = [])
    {
        foreach($params as $key => $value)
        {
            $this->$key = $value;
        }
    }

    public static function factory(array $params = [])
    {
        return view_cell(get_called_class() . '::widget', $params);
    }

    public function widget(array $params = [])
    {
        $this->setParams($params);

        return $this->run();
    }

}
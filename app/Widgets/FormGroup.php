<?php

namespace App\Widgets;

class FormGroup extends \App\Components\Widget
{

    public $label;

    public $labelOptions = [];

    public $content;

    public $error;

    public function run()
    {
        return view('widgets/form-group', [
            'label' => $this->label,
            'labelOptions' => $this->labelOptions,
            'content' => $this->content,
            'error' => $this->error,
        ], ['saveData' => false]);
    }

}
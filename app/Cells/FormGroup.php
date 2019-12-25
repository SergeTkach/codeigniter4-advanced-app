<?php

namespace App\Cells;

class FormGroup extends BaseCell
{

    public $label;

    public $labelOptions = [];

    public $content;

    public $error;

    public function cell(array $params = []) : string
    {
        $this->setParams($params);

        return $this->render('cells/form-group', [
            'label' => $this->label,
            'labelOptions' => $this->labelOptions,
            'content' => $this->content,
            'error' => $this->error,
        ]);
    }

}
<?php

namespace App\Cells;

class Alert extends BaseCell
{

    const TYPE_ERROR = 'error';

    const TYPE_INFO = 'info';

    const TYPE_SUCCESS = 'success';

    public $message;

    public $type = self::TYPE_INFO;

    public $typeOptions = [
        self::TYPE_ERROR => ['class' => 'alert alert-danger'],
        self::TYPE_INFO => ['class' => 'alert alert-info'],
        self::TYPE_SUCCESS => ['class' => 'alert alert-success']
    ];

    public function cell(array $params = []) : string
    {
        $this->setParams($params);

        if (!$this->message)
        {
            return '';
        }

        return $this->render('cells/alert', [
            'message' => $this->message,
            'options' => $this->typeOptions[$this->type]
        ]);
    }

}
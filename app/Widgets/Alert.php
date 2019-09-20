<?php

namespace App\Widgets;

class Alert extends \App\Components\Widget
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

    public function run()
    {
        if (!$this->message)
        {
            return '';
        }

        return view('widgets/alert', [
            'message' => $this->message,
            'options' => $this->typeOptions[$this->type]
        ], ['saveData' => false]);
    }

}
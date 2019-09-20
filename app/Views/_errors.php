<?php

use App\Widgets\Alert;

foreach($errors as $error)
{
    echo Alert::factory(['message' => $error, 'type' => Alert::TYPE_ERROR]);
}
<?php

use denis303\bootstrap4\Alert;

foreach($errors as $error)
{
    echo Alert::factory(['message' => $error, 'type' => 'error']);
}
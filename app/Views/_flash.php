<?php

use App\Widgets\Alert;

$session = service('session');

$success = $session->getFlashdata('success');

if ($success)
{
    echo Alert::factory(['message' => $success, 'type' => Alert::TYPE_SUCCESS]);
}

$info = $session->getFlashdata('info');

if ($info)
{
    echo Alert::factory(['message' => $info, 'type' => Alert::TYPE_INFO]);
}

$error = $session->getFlashdata('error');

if ($error)
{
    echo Alert::factory(['message' => $error, 'type' => Alert::TYPE_ERROR]);
}
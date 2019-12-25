<?php

use App\Models\UserModel;

$this->data['subject'] = 'Account registration at ' . base_url();

$this->data['mailType'] = 'text';

?>
Hello <?= esc($user->name);?>,

Follow the link below to verify your email: <?= $verifyLink;?>
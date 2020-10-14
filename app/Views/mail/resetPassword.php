<?php

use App\Models\UserModel;

$this->data['subject'] = 'Password reset for ' . base_url();

$this->data['mailType'] = 'text';

?>
Hello <?= esc($user->name);?>,

Follow the link below to reset your password: <?= $resetLink;?>
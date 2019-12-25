<?php

$this->data['subject'] = 'Message from: ' . base_url();

$this->data['mailType'] = 'text';

?>Created: <?= date('d.m.Y H:i');?>
Subject: <?= esc($subject);?>
Text: <?= esc($body);?>
<?php

use App\Cells\FormGroup;

/* @var $this \CodeIgniter\View\View */
/* @var $model \App\Forms\ResendVerificationEmailForm */

$this->data['title'] = 'Resend verification email';

$this->data['breadcrumbs'][] = $this->data['title'];

helper('form');

$this->extend('layouts/main');

?>

<?php $this->section('content');?>

<p>Please fill out your email. A verification email will be sent there.</p>

<?= form_open('user/resendVerificationEmail', ['id' => 'resend-verification-email-form']);?>

<div class="form-group">

    <label><?= $model->validationRules['email']['label'];?></label>

    <?= form_input(
        'email', 
        $data['email'] ?? '', 
        [
            'class' => 'form-control',
            'autofocus' => true
        ]
    );?>

    <div class="invalid-feedback"><?= $errors['email'] ?? '';?></div>

</div>

<?php foreach($errors as $error):?>

    <div class="alert alert-error"><?= $error;?></div>

<?php endforeach;?>

<div class="form-group">

    <?= form_submit('send', 'Send', ['class' => 'btn btn-primary']);?>

</div>

<?= form_close();?>

<?php $this->endSection();?>
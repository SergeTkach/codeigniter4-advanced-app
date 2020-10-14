<?php

use App\Cells\FormGroup;

/* @var $this \CodeIgniter\View\View */
/* @var $model \App\Forms\PasswordResetRequestForm */

$this->data['title'] = 'Request password reset';

$this->data['breadcrumbs'][] = $this->data['title'];

helper(['form']);

$this->extend('layouts/main');

?>
<?php $this->section('content');?>
    
<p>Please fill out your email. A link to reset password will be sent there.</p>

<?= form_open('user/requestPasswordReset', ['id' => 'request-password-reset-form']);?>

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

    <?= form_submit('submit', 'Send', ['class' => 'btn btn-primary']);?>

</div>

<?php form_close();?>

<?php $this->endSection();?>
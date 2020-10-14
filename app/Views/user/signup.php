<?php

/* @var $this \CodeIgniter\View\View */
/* @var $model \App\Forms\SignupForm */

$this->data['title'] = 'Signup';

$this->data['breadcrumbs'][] = $this->data['title'];

helper(['form']);

$this->extend('layouts/main');

?>
<?php $this->section('content');?>
    
<p>Please fill out the following fields to signup:</p>

<?php if(CI_DEBUG):?>
<p>
    If you did not receive a verification message on the test server, you can view the secret keys in the database and verify your account manually.
    <br>
    <b style="color: red;"><?= site_url('user/verifyEmail/:id/:email_verification_token');?></b>
</p>
<?php endif;?>

<ul>
    <li><a href="<?= site_url('user/requestPasswordReset');?>">Request password reset</a></li>
    <li><a href="<?= site_url('user/resendVerificationEmail');?>">Resend verification email</a></li>
</ul>

<?= form_open('user/signup', ['id' => 'form-signup']);?>

<div class="form-group">

    <label><?= $model->validationRules['username']['label'];?></label>

    <?= form_input(
        'username', 
        $data['username'] ?? '', 
        [
            'autofocus' => true, 
            'class' => 'form-control'
        ]
    );?>

    <div class="invalid-feedback"><?= $errors['username'] ?? '';?></div>

</div>

<div class="form-group">

    <label><?= $model->validationRules['email']['label'];?></label>

    <?= form_input(
        'email', 
        array_key_exists('email', $data) ? $data['email'] : '', 
        [
            'class' => 'form-control'
        ]
    );?>

    <div class="invalid-feedback"><?= $errors['email'] ?? '';?></div>

</div>

<div class="form-group">

    <label><?= $model->validationRules['password']['label'];?></label>

    <?= form_password(
        'password', 
        '', 
        [
            'class' => 'form-control'
        ]
    );?>

    <div class="invalid-feedback"><?= $errors['password'] ?? '';?></div>
    
</div>

<?php foreach($errors as $error):?>

    <div class="alert alert-error"><?= $error;?></div>

<?php endforeach;?>

<div class="form-group">

    <?= form_submit('signup-button', 'Signup', ['class' => 'btn btn-primary']);?>

</div>

<?= form_close();?>

<?php $this->endSection();?>
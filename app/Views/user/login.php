<?php

use App\Components\ActiveForm;

/* @var $this \CodeIgniter\View\View */
/* @var $model \App\Models\LoginForm */

$this->data['title'] = 'Login';

$this->data['breadcrumbs'][] = $this->data['title'];

helper(['form']);

$form = new ActiveForm($model);

?>

<h1><?= esc($this->data['title']);?></h1>

<p>Please fill out the following fields to login:</p>

<?= form_open('', ['id' => 'login-form']);?>

<?= view('_errors', ['errors' => array_merge($model->errors(), $errors)]);?>

<?= $form->input($data, 'username', ['autofocus' => true, 'class' => 'form-control']);?>

<?= $form->password($data, 'password', ['class' => 'form-control']);?>

<?= $form->checkbox($data, 'rememberMe');?>

<div style="color:#999;margin:1em 0">
    
    If you forgot your password you can <a href="<?= site_url('user/requestPasswordReset');?>">reset it</a>.
    
    <br>
    
    Need new verification email? <a href="<?= site_url('user/resendVerificationEmail');?>">Resend</a>

</div>

<div class="form-group">
    
    <?= form_submit('login-button', 'Login', ['class' => 'btn btn-primary']);?>

</div>

<?= form_close();?>
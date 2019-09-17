<?php

/* @var $this \CodeIgniter\View\View */
/* @var $model \App\Models\PasswordResetRequestForm */

use App\Components\ActiveForm;

$this->data['title'] = 'Request password reset';

$this->data['breadcrumbs'][] = $this->data['title'];

helper(['form']);

$form = new ActiveForm($model);

?>
    
<h1><?= esc($this->data['title']);?></h1>

<p>Please fill out your email. A link to reset password will be sent there.</p>

<?= form_open('', ['id' => 'request-password-reset-form']);?>

<?= view('_errors', ['errors' => array_merge($model->errors(), $errors)]);?>

<?= $form->input($data, 'email', ['autofocus' => true, 'class' => 'form-control']);?>

<div class="form-group">

    <?= form_submit('submit', 'Send', ['class' => 'btn btn-primary']);?>

</div>

<?php form_close();?>
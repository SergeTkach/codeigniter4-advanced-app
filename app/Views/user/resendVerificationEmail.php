<?php

use denis303\bootstrap4\FormGroup;

/* @var $this \CodeIgniter\View\View */
/* @var $model \App\Models\ResendVerificationEmailForm */

$this->data['title'] = 'Resend verification email';

$this->data['breadcrumbs'][] = $this->data['title'];

helper('form');

?>
<h1><?= esc($this->data['title']);?></h1>

<p>Please fill out your email. A verification email will be sent there.</p>

<?= form_open('', ['id' => 'resend-verification-email-form']); ?>

<?= view('_errors', ['errors' => $errors]);?>

<?= FormGroup::factory([
    'content' => form_input(
        'email', 
        array_key_exists('email', $data) ? $data['email'] : '', 
        [
            'class' => 'form-control',
            'autofocus' => true
        ]
    ),
    'label' => $model->getFieldLabel('email'),
    'error' => array_key_exists('email', $errors) ? $errors['email'] : null
]);?>

<div class="form-group">

    <?= form_submit('send', 'Send', ['class' => 'btn btn-primary']);?>

</div>

<?= form_close();?>
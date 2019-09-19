<?php

/* @var $this \CodeIgniter\View\View */
/* @var $data \App\Models\ContactForm */

use denis303\bootstrap4\Alert;
use denis303\bootstrap4\FormGroup;

$this->data['title'] = 'Contact';

$this->data['breadcrumbs'][] = $this->data['title'];

helper(['form']);

?>
<p>If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.</p>

<?php if($message):?>

<?= Alert::factory(['message' => $message, 'type' => Alert::TYPE_SUCCESS]);?>

<?php endif;?>

<?= view('_errors', ['errors' => $errors]);?>

<?= form_open('', ['id' => 'contact-form']);?>

<?= FormGroup::factory([
    'content' => form_input(
        'name', 
        array_key_exists('name', $data) ? $data['name'] : '', 
        [
            'class' => 'form-control',
            'autofocus' => true
        ]
    ),
    'label' => $model->getFieldLabel('name'),
    'error' => array_key_exists('name', $errors) ? $errors['name'] : null
]);?>

<?= FormGroup::factory([
    'content' => form_input(
        'email', 
        array_key_exists('email', $data) ? $data['email'] : '', 
        [
            'class' => 'form-control'
        ]
    ),
    'label' => $model->getFieldLabel('email'),
    'error' => array_key_exists('email', $errors) ? $errors['email'] : null
]);?>

<?= FormGroup::factory([
    'content' => form_input(
        'subject', 
        array_key_exists('subject', $data) ? $data['subject'] : '', 
        [
            'class' => 'form-control'
        ]
    ),
    'label' => $model->getFieldLabel('subject'),
    'error' => array_key_exists('subject', $errors) ? $errors['subject'] : null
]);?>

<?= FormGroup::factory([
    'content' => form_textarea(
        'body', 
        array_key_exists('body', $data) ? $data['body'] : '', 
        [
            'class' => 'form-control',
            'rows' => 6
        ]
    ),
    'label' => $model->getFieldLabel('body'),
    'error' => array_key_exists('body', $errors) ? $errors['body'] : null
]);?>

<div class="form-group">

    <?= form_submit('contact-button', 'Submit', ['class' => 'btn btn-primary']);?>

</div>

<?= form_close();?>
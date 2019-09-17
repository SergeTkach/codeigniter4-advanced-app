<?php

/* @var $this \CodeIgniter\View\View */
/* @var $data \App\Models\ContactForm */

use App\Components\Form;

$this->data['title'] = 'Contact';

$this->data['breadcrumbs'][] = $this->data['title'];

helper(['form']);

?>
<h1><?= esc($this->data['title']);?></h1>

<p>If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.</p>

<?= view('_messages', ['messages' => $messages]);?>

<?= view('_errors', ['errors' => $errors]);?>

<?= form_open('', ['id' => 'contact-form']);?>

<?php

$form = new Form($model, $data);

?>

<?= $form->input('name', ['autofocus' => true, 'class' => 'form-control']);?>

<?= $form->input('email', ['class' => 'form-control']);?>

<?= $form->input('subject', ['class' => 'form-control']);?>

<?= $form->textarea('body', ['class' => 'form-control', 'rows' => 6]);?>

<?= $form->input('verifyCode', ['class' => 'form-control']);?>

<?php

/*

    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) ?>

    */

?>

<div class="form-group">

    <?= form_submit('contact-button', 'Submit', ['class' => 'btn btn-primary']);?>

</div>

<?= form_close();?>
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?= base_url();?>/libs/bootstrap4/dist/css/bootstrap.min.css">
<title><?= empty($this->data['title']) ? 'Default app title' : esc($this->data['title']);?></title>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?= base_url();?>/libs/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url();?>/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="<?= base_url();?>/libs/bootstrap4/dist/js/bootstrap.min.js"></script>
<link rel="shortcut icon" type="image/png" href="<?= base_url();?>/favicon.ico"/>
</head>
<body>
<main role="main" class="container">
<?php if(!empty($this->data['title'])):?>

<h1><?= esc($this->data['title']);?></h1>

<?php endif;?>

<div class="mb-2"><?php require(__DIR__ . '/_menu.php');?></div>

<?php require(__DIR__ . '/_flash.php');?>

<?= $content;?>

<div class="footer">

Page rendered in {elapsed_time} seconds.<br>
Environment: <?= ENVIRONMENT;?><br>
CodeIgniter version: <?= CodeIgniter\CodeIgniter::CI_VERSION;?>

</div>

</main>
</body>
</html>
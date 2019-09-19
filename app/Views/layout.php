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
<style {csp-style-nonce}>
    div.logo {
        height: 200px;
        width: 155px;
        display: inline-block;
        opacity: 0.12;
        position: absolute;
        z-index: 0;
        top: 2rem;
        left: 50%;
        margin-left: -73px;
    }
</style>
</head>
<body>
<main role="main" class="container">

<?php if(!empty($this->data['title'])):?>

<h1><?= esc($this->data['title']);?></h1>

<?php endif;?>

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
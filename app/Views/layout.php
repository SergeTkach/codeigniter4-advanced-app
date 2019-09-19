<?php

use denis303\bootstrap4\Alert;

?>
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="/libs/bootstrap4/dist/css/bootstrap.min.css">
<title><?= empty($this->data['title']) ? 'Default app title' : esc($this->data['title']);?></title>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="/libs/jquery/dist/jquery.min.js"></script>
<script src="/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="/libs/bootstrap4/dist/js/bootstrap.min.js"></script>
<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
</head>
<body>
<main role="main" class="container">

<?php

$session = service('session');

$success = $session->getFlashdata('success');

if ($success)
{
    echo Alert::factory(['message' => $success, 'type' => Alert::TYPE_SUCCESS]);
}

$info = $session->getFlashdata('info');

if ($info)
{
    echo Alert::factory(['message' => $info, 'type' => Alert::TYPE_INFO]);
}

$error = $session->getFlashdata('error');

if ($error)
{
    echo Alert::factory(['message' => $error, 'type' => Alert::TYPE_ERROR]);
}


?>

<?= $content;?>


</main>
</body>
</html>
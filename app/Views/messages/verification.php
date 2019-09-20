<?php

use App\Models\UserModel;

?>
<p>Hello <?= esc(UserModel::getUserName($user));?>,</p>

<p>Follow the link below to verify your email:</p>

<p><a href="<?= $verifyLink;?>"><?= esc($verifyLink);?></a></p>
<?php

use App\Models\UserModel;

?>
<p>Hello <?= esc(UserModel::getUserName($user));?>,</p>

<p>Follow the link below to reset your password:</p>

<p><a href="<?= $resetLink;?>"><?= esc($resetLink);?></a></p>
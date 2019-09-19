<p>Hello <?= esc($user->user_name);?>,</p>

<p>Follow the link below to reset your password:</p>

<p><a href="<?= $resetLink;?>"><?= esc($resetLink);?></a></p>
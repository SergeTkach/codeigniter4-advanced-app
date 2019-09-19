<p>Hello <?= esc($user->user_name);?>,</p>

<p>Follow the link below to verify your email:</p>

<p><a href="<?= $verifyLink;?>"><?= esc($verifyLink);?></a></p>
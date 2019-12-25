<?php

if (empty($labelOptions['class']))
{
    $labelOptions['class'] = 'control-label';
}

$attrs = stringify_attributes($labelOptions);

?>

<div class="form-group">

    <label<?= $attrs;?>><?= $label;?></label>

    <?= $content;?>

    <?php if($error):?>

        <p class="help-block help-block-error"><?= $error;?></p>

    <?php endif;?>

</div>
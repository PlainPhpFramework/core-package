<?php ob_start() ?>
<input <?=attr_for($element, ['class' => 'form-range'])?>>
<?php $field = ob_get_clean() ?>
<?php require form_resolve_path('element.php') ?>
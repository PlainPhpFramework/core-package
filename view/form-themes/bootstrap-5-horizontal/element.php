<?php
$field_class = @$field_class?: 'form-control';
$label_class = @$label_class?: 'form-label';
$label_before = isset($label_before)? $label_before : true;

ob_start();
echo label_for($element, ['class' => $label_class]);
$label = ob_get_clean();

if (!@$field) {
	ob_start(); ?>
	<input <?=attr_for($element, ['class' => $field_class])?>>
	<?php
	$field = ob_get_clean();
}
?>

<?php ob_start() ?>

	<?php
	if ($label_before) echo $label;
	echo $field;
	if (!$label_before) echo $label;
	?>

	<?php if ($element->error): ?>
		<div class="invalid-feedback">
			<?=@$element->extra['error:allow_html'] === true? $element->error: htmlspecialchars($element->error)?>
		</div>
	<?php endif ?>

	<?php if ($element->help): ?>
		<div class="form-text">
			<?=@$element->extra['help:allow_html'] === true? $element->help: htmlspecialchars($element->help)?>
		</div>
	<?php endif ?>

<?php $content = ob_get_clean() ?>

<?php 
unset($field_class, $label_class, $label_before);
require form_resolve_path('row.php') ?>
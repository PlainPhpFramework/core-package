<?php ob_start() ?>
<textarea <?=attr_for($element, [
	'rows' => @$element->attributes['rows']? htmlspecialchars($element->attributes['rows']): '3', 
	'class' => 'form-control'
])?>><?=htmlspecialchars($element->value)?></textarea>
<?php $field = ob_get_clean() ?>
<?php require form_resolve_path('element.php') ?>
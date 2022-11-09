<?php ob_start() ?>
<?php foreach($element->elements as $checkbox): ?>
	<div class="form-check <?php if (!($checkbox instanceof pp\Form\Radio)): ?>  form-switch<?php endif ?>">
		<input <?=attr_for($checkbox, ['class' => 'form-check-input'])?>>
		<?=label_for($checkbox, ['class' => 'form-check-label'])?>
	</div>
<?php endforeach ?>
<?php
$content = ob_get_clean();
require form_resolve_path('row.php');
?>
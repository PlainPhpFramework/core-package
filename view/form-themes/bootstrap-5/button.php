<?php ob_start() ?>

	<button <?=attr_for($element, [
		'class' => @$button_class?: 'btn btn btn-secondary',
	])?>>
		<?=htmlspecialchars($element->getLabel())?>
	</button>

<?php
$button_class = null;
$content = ob_get_clean();
require form_resolve_path('row.php');
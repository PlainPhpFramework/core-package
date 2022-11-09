<?php if ($element->label): ?>
	<fieldset>
	<legend><?=htmlspecialchars($element->label)?></legend>
<?php endif ?>

<?php
foreach ($element->elements as $child) {
	form_widget($child);
}
?>

<?php if ($element->label): ?>
	</fieldset>	
<?php endif ?>

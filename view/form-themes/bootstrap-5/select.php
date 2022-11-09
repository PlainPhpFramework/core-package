<?php ob_start() ?>

	<select <?=attr_for($element)?> class="form-select">
		<?php foreach($element->elements as $subElement): ?>

			<?php if ($subElement instanceof pp\Form\OptionGroup): ?>

				<?php $options = $subElement->elements ?>

				<optgroup label="<?=e($element->getLabel())?>">

			<?php else: $options = [$subElement]; endif ?>

			<?php foreach($options as $option): ?>
				<option <?=attr_for($option)?>><?=e($option->getLabel())?></option>
			<?php endforeach ?>

			<?php if ($subElement instanceof pp\form\OptionGroup): ?>

				</optgroup>

			<?php endif ?>

		<?php endforeach ?>
	</select>

<?php
$field = ob_get_clean();
require form_resolve_path('element.php');
?>

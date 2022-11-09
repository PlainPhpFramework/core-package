<?php
$row_class = @$row_class?: 'col-12';
?>
<div class="<?=@$element->extra['row:class']? e($element->extra['row:class']): $row_class?>">
	<?=@$content; $content = null ?>
</div>
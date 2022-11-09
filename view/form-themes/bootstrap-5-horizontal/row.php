<?php
$row_class = 'col-auto';
?>
<div class="<?=@$element->extra['row:class']? e($element->extra['row:class']): $row_class?>">
	<?=@$content; $content = null ?>
</div>
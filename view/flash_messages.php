<?php if (!empty($_SESSION['flash_messages'])): ?>
	<?php foreach ($_SESSION['flash_messages'] as $message): ?>
		<?php list($type, $message) = $message ?>
		<div class="alert alert-<?=$type?>" role="alert">
		  <?=$message?>
		</div>
	<?php endforeach ?>
<?php $_SESSION['flash_messages'] = []; endif ?>
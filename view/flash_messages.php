<?php if (!empty($_SESSION['flash_messages'])): ?>
	<?php foreach ($_SESSION['flash_messages'] as $message): ?>
		<?php list($type, $message) = $message ?>
		<div class="alert alert-<?=$type?> text-center alert-dismissible fade show my-1" role="alert">
		  <?=$message?>
		  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php endforeach ?>
<?php $_SESSION['flash_messages'] = []; endif ?>
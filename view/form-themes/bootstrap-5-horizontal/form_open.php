<?php
$form_class = @$form_class? $form_class: 'row g-3 align-items-center';
if ($form->isValidated) {
	$form_class .= ' was-validated';
}
?>
<form <?=attr_for($form, ['class' => $form_class])?>>

<?php if ($form->error): ?>
	
	<?php ob_start() ?>
	
	<div class="alert alert-danger" role="alert">
		<?=@$form->extra['error:allow_html'] === true? $form->error: htmlspecialchars($form->error)?>
	</div>

	<?php 
	$content = ob_get_clean();
	require form_resolve_path('row.php');
	?>

<?php endif ?>
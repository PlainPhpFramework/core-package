<?php $content = get_ob() ?>
<!doctype html>
<html class="no-js" lang="<?=@$lang ?: 'en'?>">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script>
	document.documentElement.classList.replace('no-js', 'js');
	var jq = [];
	</script>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


	<?=@$head?>

	<title><?=@$title?></title>
	<?php if (@$canonical): ?>
		<link rel="canonical" href="<?=$canonical?>">
	<?php endif ?>
	<?php if (@$robots): ?>
		<meta name="robots" content="<?=$robots?>">
	<?php endif ?>
	<?php if (@$description): ?>
		<meta name="description" content="<?=$description?>">
	<?php endif ?>
</head>
<body<?php if(@$body_classes): ?> class="<?=$body_classes?>"<?php endif?>>

	<?php require 'view/flash_messages.php' ?>

	<?=$content?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

	<?=@$foot?>
	
	<script>
	<?php // Run JavaScript on idle ?> 
	(function(timeout) {
		if ('requestIdleCallback' in window) {
			if(jq.length > 0) {
				requestIdleCallback(function me(deadline){
					while (deadline.timeRemaining() > 0 && jq.length > 0) {
						jq.shift()();
					}

					if (jq.length > 0) {
						requestIdleCallback(me, {timeout: timeout});
					}
				}, {timeout: timeout});
			} 
		} else {
			jq.forEach(function(callback){
				setTimeout(callback, 1);
			});			 
		}
		jq.push = function(callback){callback()};
	})(2000);
	</script>
</body>
</html>
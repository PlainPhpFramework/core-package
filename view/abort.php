<?php 
$title = sprintf('Error %', $statusCode);
?>
<div class="container">
  <div class="jumbotron bg-white text-center">
    <h1 class="display-4"><?=$statusCode?></h1>
    
    <?php if (@$message) echo $message; else: ?>
	    <p class="lead">Looks like we're having some server issues.</p>
	    <hr class="my-4">
	    <p>Go back to the previous page and try again. If you think something is broken, report a problem.</p>
	    <a class="btn btn-primary btn-lg" href="mailto:<?=get('config')->webmaster_email?>" role="button">Report a problem</a>
	<?php endif ?>

    <?php if (IS_DEV): ?>
		<p class="mt-4 text-left">Debug information:</p>
		<div class="text-left"><?php var_dump($exception) ?></div>
    <?php endif ?>

  </div>
<div>
<?php require 'view/base.php' ?>
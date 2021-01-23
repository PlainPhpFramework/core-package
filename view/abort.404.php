<p class="lead">Oops, the page you're looking for does not exist!</p>
<p>You may want to head back to the homepage. If you think something is broken, report a problem.</p>
<a class="btn btn-primary btn-lg" href="<?=url()?>" role="button">Go to homepage</a>
<a class="btn btn-primary btn-lg" href="mailto:<?=get('config')->webmaster_email?>" role="button">Report a problem</a>
<?php $message = ob_get_clean() ?>
<?php require 'view/abort.php' ?>
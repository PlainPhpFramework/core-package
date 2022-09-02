<?php 
if (@$email) {
	$email->subject("Test email!");

	@$from && $email->from($from);
	@$to && $email->to($to);
}
?>

<h1>Test email</h1>

<p>This is a test email!</p>

<?php require 'email/layout.php' ?>
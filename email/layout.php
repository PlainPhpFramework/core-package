<?php 
$content = get_ob(); 
?>

<style>
	.container {
		background: #eee;
		padding-top: 20px;
		padding-right: 20px;
		padding-bottom: 20px;
		padding-left: 20px;
		font-family: -apple-system, BlinkMacSystemFont, avenir next, avenir, segoe ui, helvetica neue, helvetica, Cantarell, Ubuntu, roboto, noto, arial, sans-serif;
	}

	.wrapper {
		max-width: 500px;
		margin: auto;
		padding-top: 20px;
		padding-right: 20px;
		padding-bottom: 20px;
		padding-left: 20px;
		background: #fff;
	}

	.header {
		text-align: center;
		padding-top: 20px;
		padding-bottom: 20px;
	}

	h1 {
		font-size: 20px; font-weight: 300;
	}

	.btn {
		color:#fff;display:inline-block;padding:7px 15px;font-weight:600;background: #007bff; color:#fff;text-decoration:none;border-radius: 5px;
	}

	.text-center{ text-align: center;}

</style>

<div class="container">

    <div class="wrapper">

		<div class="header">
			<a href="<?=url()?>" target="_blank">
				<img src="<?=asset('assets/images/logo.email.png')?>">
			</a>
		</div>

		<?=$content?>

	</div>

</div>

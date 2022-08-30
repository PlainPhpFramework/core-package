<?php 
$config = get('config');
$this->addEmbeddedImage($config->email_logo_path, 'logo');
$content = get_ob(); 
?>

<div style="background: #eee; padding-top: 20px;  padding-right: 20px;  padding-bottom: 20px;  padding-left: 20px;">

    <div style="max-width: 500px; margin: auto; padding-top: 20px;padding-right: 20px;padding-bottom: 20px;padding-left: 20px;background: #fff;">

		<div style="text-align: center;padding-top: 20px; padding-bottom: 20px">
			<a href="<?=url()?>">
				<img src="cid:logo" width="<?=$config->email_logo_width?>" height="<?=$config->email_logo_height?>">
			</a>
		</div>
		<?=$content?>
	</div>

</div>

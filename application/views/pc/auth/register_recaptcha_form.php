<?php
$attributes = array('class' => 'form-horizontal');

$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'size'	=> 30,
	'value' =>  set_value('username')
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
	'value' => set_value('password')
);

$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'size'	=> 30,
	'value' => set_value('confirm_password')
);

$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'maxlength'	=> 80,
	'size'	=> 30,
	'value'	=> set_value('email')
);
?>
<fieldset><legend>登録</legend>
<?php echo form_open($this->uri->uri_string(), $attributes)?>



	<div class="control-group">
		<label class="control-label" for="name">ユーザー名</label>
		<div class="controls">
			<?php echo form_error($username['name']); ?>
			<?php echo form_input($username)?>
			<p class="help-block"></p>
		</div>
	</div>




	<div class="control-group">
		<label class="control-label" for="password">パスワード</label>
		<div class="controls">
			<?php echo form_error($password['name']); ?>
			<?php echo form_password($password)?>
			
			<p class="help-block"></p>
		</div>
	</div>



	<div class="control-group">
		<label class="control-label" for="confirm_password">パスワード(再入力)</label>
		<div class="controls">
			<?php echo form_error($confirm_password['name']); ?>
			<?php echo form_password($cnfirm_password)?>
			<p class="help-block"></p>
		</div>
	</div>



	<div class="control-group">
		<label class="control-label" for="email">メールアドレス</label>
		<div class="controls">
			<?php echo form_error($email['name']); ?>
			<?php echo form_input($email)?>
			<p class="help-block"></p>
		</div>
	</div>






<?php if ($this->dx_auth->captcha_registration): ?>
	<div class="control-group">
		<label class="control-label" for="email">画像の中の文字を入力してください</label>
		<div class="controls">
			<?php echo $this->dx_auth->get_captcha_image(); ?>
			<br>
			<?php echo form_error($captcha['name']); ?>
			<?php echo form_input($captcha)?>
			<p class="help-block">（数字のゼロは入っていません）</p>
		</div>
	</div>

<?php endif; ?>








		
<?php if ($this->dx_auth->captcha_registration): ?>
	<div class="control-group">
		<label class="control-label" for="email"></label>
		<div class="controls">
			<?php echo $this->dx_auth->get_captcha_image(); ?>
			

				<?php 
					// Show recaptcha imgage
					echo $this->dx_auth->get_recaptcha_image(); 
					// Show reload captcha link
					echo $this->dx_auth->get_recaptcha_reload_link(); 
					// Show switch to image captcha or audio link
					echo $this->dx_auth->get_recaptcha_switch_image_audio_link(); 
				?>

			<?php echo $this->dx_auth->get_recaptcha_label(); ?>
			
				<?php echo $this->dx_auth->get_recaptcha_input(); ?>
				<?php echo form_error('recaptcha_response_field'); ?>
			
			
			<?php 
				// Get recaptcha javascript and non javasript html
				echo $this->dx_auth->get_recaptcha_html();
			?>


		</div>
	</div>

<?php endif; ?>


<div class="form-actions">

<?php echo form_submit('regist','　　設定　　','data-loading-text="処理中…" class="btn btn-small btn-primary"');?>

</div>

<script type="text/javascript"> 
  $('.btn-primary').on('click', function () {
    $(this).button('loading')
  })
</script> 

<br />



<?php echo form_close()?>
</fieldset>

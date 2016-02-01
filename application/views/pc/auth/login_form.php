<?php
$attributes = array('class' => 'form-horizontal');

$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	//'size'	=> 30,
	'value' => set_value('username'),
	'class' => 'form-control'
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	//'size'	=> 30,
	'class' => 'form-control'
);

$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> TRUE,
	'style' => 'margin:0;padding:0'
);

$confirmation_code = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	//'maxlength'	=> 8
	'class' => 'form-control'
);

?>




<!--contentBlock-->
	<div id="otherBlock" class="clearF">
		<div class="inner">
	
	<h2 class="heading_life">ログインフォーム<span></span></h2>


<div  style="width:95%; max-width:700px; margin:30px auto; padding:10px; border:1px solid #CCC; border-radius:10px; ">
	<h3 style="margin-top:0px;"><?=$message?></h3>

<?php echo form_open($this->uri->uri_string(), $attributes)?>
	<?php echo $this->dx_auth->get_auth_error(); ?>


  <div class="form-group">
		<label class="col-sm-2 control-label" for="username">メールアドレス</label>
    <div class="col-sm-7">
			<?php echo form_error($username['name']); ?>
			<?php echo form_input($username);?>
		</div>
	</div>


	 <div class="form-group">
		<label class="col-sm-2 control-label" for="password">パスワード</label>
    <div class="col-sm-7">
			<?php echo form_error($password['name']); ?>
			<?php echo form_password($password);?>
			
			</div>
	</div>



	
	
<?php if ($show_captcha): ?>

	<div class="form-group">
		<label class="col-sm-2 control-label" for="password">画像に描かれている文字を入力してください</label>
		<div class="col-sm-7">
			<?php echo $this->dx_auth->get_captcha_image(); ?>
			<?php echo form_input($confirmation_code);?>
			<?php echo form_error($confirmation_code['name']); ?>
			<p class="help-block">（数字のゼロは入っていません）</p>
		</div>
	</div>

	
	<div class="form-group">
		<label class="control-label" for="remember"></label>
		<div class="col-sm-7">
			<?php echo form_checkbox($remember);?> <?php echo form_label('次回から自動的にログイン', $remember['id']);?> 
			<p class="help-block"></p>
		</div>
	</div>

	

	
<?php endif; ?>


<div class="form-actions" align="center">
<?php echo form_submit('regist','　　ログイン　　','data-loading-text="処理中…" class="btn btn-success"');?>　
</div>

	
	
	
	<hr>
	
	<div style="text-align:center;">
			<?php echo anchor($this->dx_auth->forgot_password_uri, 'パスワードを忘れた');?> 
	</div>
	
	
	
<?php
	if ($this->dx_auth->allow_registration) {
?>
	<hr>
<div style="text-align:center;">
<a href="<?php echo site_url($this->dx_auth->register_uri); ?>"><button class="btn btn-default btn-xs"><i class="icon-user icon-white"></i>新規登録</button></a>
</div>
<?php
	};
?>
	
	
<script type="text/javascript"> 
  $('.btn-success').on('click', function () {
    $(this).button('loading')
  })
</script> 

<br />

<?php echo form_close()?>
</div>
	</div>
<!--//contentWrap-->
</div>


















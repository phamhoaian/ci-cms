<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'size'	=> 20,
	'value' => set_value('username')
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 20
);

$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0'
);

$confirmation_code = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8
);

?>

<div align="center">
<?=mb_convert_kana($message,"ak")?>
</div>


<?php echo form_open($this->uri->uri_string())?>
<br />
<?php echo $this->dx_auth->get_auth_error(); ?>
<br />
<?=$this->emoji->Convert("F977")?>
<?php echo form_label('ﾒｰﾙｱﾄﾞﾚｽ', $username['id']);?>
<br />
<?php echo form_input($username)?>
<?php echo form_error($username['name']); ?>

<br />
<?=$this->emoji->Convert("F97D")?>
<?php echo form_label('ﾊﾟｽﾜｰﾄﾞ', $password['id']);?>
<br />
<?php echo form_password($password)?>
<?php echo form_error($password['name']); ?>

<br />

<?php if ($show_captcha): ?>

画像に描かれている文字を入力してください。（数字のゼロは入っていません）<br />

<?php echo $this->dx_auth->get_captcha_image(); ?>
<?php echo form_label('画像に描かれている文字を入れてください', $confirmation_code['id']);?>
<br />
<?php echo form_input($confirmation_code);?>
<?php echo form_error($confirmation_code['name']); ?>

	
<?php endif; ?>


<?php echo form_checkbox($remember);?> <?php echo form_label('自動ﾛｸﾞｲﾝ', $remember['id']);?> 

<br />
<?=$this->emoji->Convert("F9A7")?>
<?php echo anchor($this->dx_auth->forgot_password_uri, 'ﾊﾟｽﾜｰﾄﾞを忘れた');?> 

<br />



<?php
	if ($this->dx_auth->allow_registration) {
		echo $this->emoji->Convert("F981");
		echo anchor($this->dx_auth->register_uri, '新規登録');
	};
?>


<br />


<?php echo form_submit('login','ログイン');?>


<?php echo form_close()?>






<?php

$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'maxlength'	=> 80,
	'size'	=> 30,
	'value' => set_value('login')
);


$year = array();
$default_select = "";
$year[""] = "---";
for($i=1930 ; $i<=date("Y");$i++){
	$year["$i"] = $i;
	set_select('year',$i);
	#if($i == 1976 and !$this->input->post('year'))
	#{
	#	$year[""] = "----";
	#}
}


$month = array();
$default_select = "";
$month[""] = "--";
for($i=1 ; $i<=12;$i++){
	$month["$i"] = $i;
	set_select('month',$i);
}

$day = array();
$default_select = "";
$day[""] = "--";
for($i=1 ; $i<=31;$i++){
	$day["$i"] = $i;
	set_select('day',$i);
}


$blood_list = array("A","O","B","AB");
$blood = array();
$blood[""] = "-";
foreach($blood_list as $row)
{
	$blood["$row"] = $row;
	set_select('blood',$row);
}


?>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<fieldset><legend accesskey="D" tabindex="1">パスワード再発行</legend>
<?php echo form_open($this->uri->uri_string()); ?>

<?php echo $this->dx_auth->get_auth_error(); ?>

<dl>
	<dt><?php echo form_label('メールアドレス', $login['id']);?></dt>
	<dd>
		<?php echo form_input($login); ?> 
		<?php echo form_error($login['name']); ?>
	</dd>
</dl>

<dl>
	<dt><?php echo form_label('生年月日');?></dt>
	<dd>
	<?php echo form_dropdown('year', $year); ?>年
	
	<?php echo form_dropdown('month', $month); ?>月
	
	<?php echo form_dropdown('day', $day); ?>日
	
	<?php echo form_error('year'); ?>
	<?php echo form_error('month'); ?>
	<?php echo form_error('day'); ?>
	</dd>
	
	<br />
	
</dl>

<dl>
	<dd>
		<?php echo form_submit('reset', 'パスワード再発行'); ?>
	</dd>
</dl>


<?php echo form_close()?>
</fieldset>
<?php

$sex[] = array(
    'name'        => 'sex',
    'id'          => '1',
    'value'       => '1',
    'value_jp'       => '男性',
    'checked'     => set_radio('sex', '1'),
    'style'       => 'margin:10px',
    );

$sex[] = array(
    'name'        => 'sex',
    'id'          => '2',
    'value'       => '2',
    'value_jp'       => '女性',
    'checked'     => set_radio('sex', '2'),
    'style'       => 'margin:10px',
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



$pref_list = $this->myauth_model->get_pref_list();
$pref= array();
$pref[""] = "-------";
foreach($pref_list as $row)
{
	$pref["{$row->id}"] = $row->name;
	set_select('pref',$row->id);
}



$work_type_list = $this->myauth_model->get_worktype_list();
$work_type= array();
$work_type[""] = "-------";
foreach($work_type_list as $row)
{
	$work_type["{$row->id}"] = $row->name;
	set_select('work_type',$row->id);
}


?>



<strong>登録</strong>
<br />

<?php //echo form_open($this->uri->uri_string())?>
<?php echo form_open(site_url("auth/activate/".$username."/".$key))?>
<dl>

	
	<dt><?php echo form_label('性別', $sex[0]["name"]);?></dt>
	<dd>
<?php foreach($sex as $row): ?>
	<?php echo form_label("$row[value_jp]", "$row[id]");?>

		<?php echo form_radio($row);?>
		

<?php endforeach; ?>
	<?php echo form_error('sex'); ?>
	</dd>
	
	
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
	
	<dt><?php echo form_label('血液型','blood');?></dt>
	<dd>
	<?php echo form_dropdown('blood', $blood); ?>型
	<?php echo form_error('blood'); ?>
	</dd>
	
	
	
	<dt><?php echo form_label('お住まい','pref');?></dt>
	<dd>
	<?php echo form_dropdown('pref', $pref); ?>
	<?php echo form_error('pref'); ?>
	</dd>
	
	
	
	<dt><?php echo form_label('職業','work_type');?></dt>
	<dd>
	<?php echo form_dropdown('work_type', $work_type); ?>
	<?php echo form_error('work_type'); ?>
	</dd>
	

	<dt></dt>
	<dd><?php echo form_submit('register','登録');?></dd>
</dl>

<?php echo form_close()?>


<?php
$attributes = array('class' => 'form-horizontal');
$class = 'class="input-small"';

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
for($i=1950 ; $i<=date("Y");$i++){
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



<?php echo form_open($this->uri->uri_string(), $attributes)?>


	<div class="control-group">
		<label class="control-label" for="sex">性別（<span style="color:#FF0000"><strong>＊</strong></span>）</label>
		<div class="controls">
			<?php echo form_error('sex'); ?>
<?php foreach($sex as $row): ?>
			<?php echo form_label("$row[value_jp]", "$row[id]");?>
			<?php echo form_radio($row);?>
<?php endforeach; ?>
			<p class="help-block"></p>
		</div>
	</div>
	



	
	
	<div class="control-group">
		<label class="control-label" for="birth">生年月日（<span style="color:#FF0000"><strong>＊</strong></span>）
</label>
		<div class="controls">
			<?php echo form_error('year'); ?>
			<?php echo form_error('month'); ?>
			<?php echo form_error('day'); ?>
		
			<?php echo form_dropdown('year', $year,'',$class); ?>年
			
			<?php echo form_dropdown('month', $month,'',$class); ?>月
			
			<?php echo form_dropdown('day', $day,'',$class); ?>日
			
			<p class="help-block"></p>
		</div>
	</div>	
	
	
	
	
	
	
	<div class="control-group">
		<label class="control-label" for="birth">血液型</label>
		<div class="controls">
			<?php echo form_error('blood'); ?>
			<?php echo form_dropdown('blood', $blood,'',$class); ?>型
			<p class="help-block"></p>
		</div>
	</div>	
	
	
	
	
	<div class="control-group">
		<label class="control-label" for="birth">都道府県（<span style="color:#FF0000"><strong>＊</strong></span>）
</label>
		<div class="controls">
			<?php echo form_error('pref'); ?>
			<?php echo form_dropdown('pref', $pref); ?>
			
			<p class="help-block"></p>
		</div>
	</div>	
	
	
	
	
	
	<div class="control-group">
		<label class="control-label" for="work_type">職業（<span style="color:#FF0000"><strong>＊</strong></span>）
</label>
		<div class="controls">
			<?php echo form_error('work_type'); ?>
			<?php echo form_dropdown('work_type', $work_type); ?>
			<p class="help-block"></p>
		</div>
	</div>	
	
	
	


	<div class="control-group">
			<p class="help-block">「<span style="color:#FF0000"><strong>＊</strong></span>」は必須項目</p>
	</div>


<br />


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



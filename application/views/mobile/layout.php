<?php echo $header;?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS" />

<?php
if(isset($title) && $title)
{
	print "<title>{$title} - {$this->config->item('site_name', 'config_main')}</title>\n";
}
else
{
	print "<title>{$this->config->item('site_name', 'config_main')}</title>\n";
}
if(isset($description) && $description)
{
	print '<meta name="description" content="'.$description.'">'."\n";
}
if(isset($description) && $description)
{
	print '<meta name="keywords" content="'.$keywords.'">'."\n";
}
?>
</head>
<body>

<?php $this->load->view('mobile/parts/header');?>

<?php 
if(isset($position) and $position)
{
	echo $position;
}
?>

<?php echo $main ?>

<!-- footer -->
<?php $this->load->view('mobile/parts/footer');?>

</body>
</html>

<?php
/* End of file layout.php */
/* Location: ./system/modules/html/views/layout.php */
?>

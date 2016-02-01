<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta id="viewport" name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
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
<?php echo $css;?>
<?php echo $js;?>
</head>
<body>

<?php $this->load->view('smartphone/parts/header');?>


<?php echo $main ?>

<!-- footer -->
<?php $this->load->view('smartphone/parts/footer');?>

</body>
</html>

<?php
/* End of file layout.php */
/* Location: ./system/modules/html/views/layout.php */
?>

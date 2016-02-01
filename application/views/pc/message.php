<br>
<div style="text-align:center;"><?php echo $main; ?></div>
<br><br><br>

<?php if (defined('RETURN_URL')) { ?>
	<div style="text-align: center;">[<a href="<?php echo RETURN_URL; ?>">&nbsp;戻る&nbsp;</a>]</div>
<?php } else { ?>
	<div style="text-align: center;">[<a href="#" onClick="history.back(); return false;">&nbsp;戻る&nbsp;</a>]</div>
<?php } ?>
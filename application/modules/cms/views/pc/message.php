<?php if ($this->session->flashdata('error')) { ?>
<div class="alert alert-danger alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4 class="alert-heading">Error</h4>
    <p class="alert-message"><?php echo $this->session->flashdata('error'); ?></p>
</div>
<?php } ?>
<?php if ($this->session->flashdata('message')) { ?>
<div class="alert alert-success alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4 class="alert-heading">Message</h4>
    <p class="alert-message"><?php echo $this->session->flashdata('message'); ?></p>
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="error-container">
            <div class="well">
                <h3 class="grey lighter smaller">
                    <span class="blue bigger-125">
                        <i class="icon-ok"></i>
                        <?php echo $main; ?>
                    </span>
                </h3>
            </div>
            <div class="space"></div>
            <div class="center">
                <?php if (defined('RETURN_URL')) { ?>
                    <a href="<?php echo RETURN_URL; ?>" class="btn btn-default"><i class="icon-left"></i>&nbsp;Return</a>
                <?php } else { ?>
                    <a href="#" onClick="history.back();
                        return false;" class="btn btn-default"><i class="icon-left"></i>&nbsp;Return</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
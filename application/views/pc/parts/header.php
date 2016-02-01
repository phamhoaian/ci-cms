<header>
  <div class="container">
    <h1>
        <a href="<?php echo site_url(); ?>">
            <img src="<?php echo base_url();?>common/img/logo.png" alt="<?php echo SITE_NAME;?>"/>
        </a>
        <span class="namePref"></span>
    </h1>
    <div class="searchBox clearfix">
        <?php
        // 会員名
        $word = array(
            'name'	=> 'word',
            'value' => set_value('word'),
            'placeholder' => '市町村名から検索'
        );?>
        <?php $attributes = array('id' => 'searchForm'); ?>
        <?php echo form_open(site_url("top/search"), $attributes); ?>
            <?php echo form_hidden("pref", isset($pref["id"]) ? $pref["id"] : ""); ?>
            <?php echo form_input($word); ?>
            <?php echo form_error($word['name']); ?>
            <?php echo form_submit('btnSearch','','class="btnSearch"'); ?>
        <?php echo form_close(); ?>
    </div>
  </div>
</header>
<section id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php if (isset($items) && $items) : ?>
                    <?php foreach ($items as $item) : ?>
                    <article>
                    	<div class="entry text-center">
                            <?php if ($item["image"]) { ?>
                                <?php 
                                $file_dir = FCPATH.$this->out_img_dir."/";
                                $file_thumbnail = $file_dir.$item["id"]."_900.".$item["image"];
                                if (file_exists($file_thumbnail)) {
                                ?>
                                <div class="entry-thumbnail">
                                	<a href="<?php echo site_url("blog/detail/".$item["id"]); ?>">
                                		<img src="<?php echo base_url()."images/blog/items/".$item["id"]."_900.".$item["image"]; ?>" alt="<?php echo $item["title"] ?>" />
                                	</a>
                                </div>
                                <?php } ?>
                            <?php } ?>
                            <div class="entry-header">
                            	<div class="entry-date">
                            		<span class="day"><?php echo date('d', strtotime($item["published_date"])) ?></span>
                            		<span class="month"><?php echo date('M', strtotime($item["published_date"])) ?></span>
                            		<span class="divider"></span>
                            	</div>
                                <h2 class="entry-title">
                                    <a href="<?php echo site_url("blog/detail/".$item["id"]); ?>"><?php echo $item["title"]; ?></a>
                                </h2>
                                <div class="entry-meta">
                                    <span>
                                        <i class="fa fa-user"></i>
                                        Administrator
                                    </span>
                                    <span>
                                        <i class="fa fa-comment"></i>
                                        999 Comments
                                    </span>
                                </div>
                            </div>
                            <div class="entry-content">
                            <?php
                                if ($item["introtext"] != "") {
                                    if (str_word_count($item["introtext"]) > 10) {
                                        $introtext = explode(" ", $item["introtext"]);
                                        $pos = $introtext[9];
                                        echo substr($item["introtext"], 0, 100)."...";
                                    } else {
                                        echo $item["introtext"];
                                    }
                                } else if ($item["fulltext"] != ""){
                                    if (str_word_count($item["fulltext"]) > 10) {
                                        echo substr($item["fulltext"], 0, 10)."...";
                                    } else {
                                        echo $item["fulltext"];
                                    }
                                }
                            ?>
                            </div>
                            <a class="entry-readmore" href="<?php echo site_url("blog/detail/".$item["id"]); ?>">Read more</a>
                        </div>
                    </article>
                    <?php endforeach; ?>
                    <?php echo $pagination; ?>
                <?php endif; ?>
            </div>
            <div class="col-md-3">
                Right sidebar
            </div>
        </div>
    </div>
</section>
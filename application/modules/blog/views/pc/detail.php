<section id="main-content">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<article>
					<div class="entry">
						<div class="content-header">
							<div class="gr-table">
								<div class="gr-table-cell">
									<div class="entry-date">
										<span class="day"><?php echo date('d', strtotime($item["published_date"])) ?></span>
                            			<span class="month"><?php echo date('M', strtotime($item["published_date"])) ?></span>
                            			<span class="divider"></span>
									</div>
								</div>
								<div class="gr-table-cell">
									<h1 class="entry-title"><?php echo $item["title"]; ?></h1>
									<div class="entry-meta">
                                        <span>
                                            <i class="fa fa-pencil"></i>
                                            Administrator
                                        </span>
                                        <span>
                                            <i class="fa fa-comments"></i>
                                            999 Comments
                                        </span>
                                    </div>
								</div>
							</div>
						</div>
						<!-- /content-header  -->
						<?php if ($item["image"]) { ?>
                            <?php 
                            $file_dir = FCPATH.$this->out_img_dir."/";
                            $file_thumbnail = $file_dir.$item["id"]."_900.".$item["image"];
                            if (file_exists($file_thumbnail)) {
                            ?>
                            <div class="content-thumbnail">
                        		<img src="<?php echo base_url()."images/blog/items/".$item["id"]."_900.".$item["image"]; ?>" alt="<?php echo $item["title"] ?>" />
                            </div>
                            <!-- /content-thumbnail -->
                            <?php } ?>
                        <?php } ?>
                        <div class="content-main">
                        	<?php echo $item["introtext"]; ?>
                        	<?php echo $item["fulltext"]; ?>
                        </div>
                        <!-- /content-main -->
                        <?php if ($list_tags && count($list_tags) > 0) : ?>
                        <div class="content-keyword">
                            <span class="tag-label floatL">
                                <i class="fa fa-tags"></i>
                                Tags: 
                            </span>
                            <ul class="tags red">
                                <?php foreach ($list_tags as $tag) : ?>
                                <li>
                                    <a href="<?php echo site_url("blog/tag/".$tag["name"]); ?>">
                                        <?php echo $tag["name"]; ?>
                                        <span><?php echo $tag["count"] ?></span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        <!-- /content-keyword -->
                        <div class="content-author">
                        	<div class="gr-table align-middle">
                        		<div class="gr-table-cell">
                        			<div class="gr-table align-middle">
                                		<div class="gr-table-cell">
                                			<a class="author-avatar" href="#">
                                				<img alt="" src="<?php echo base_url(); ?>common/img/profile-img.jpg">
                                			</a>
                                		</div>
                                		<div class="gr-table-cell PL20">
                                			<h3 class="author-title">ROBERT WILLIAM</h3>
                                			<p class="author-info">GS. ENGINEER DIRECTOR</p>
                                		</div>
                                	</div>
                        		</div>
                        		<div class="gr-table-cell last">
                        			<ul class="author-social">
                        				<li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fa fa-rss"></i></a></li>
                    				</ul>
                        		</div>
                        	</div>
                        </div>
                        <!-- /content-author -->
                        <?php if ($related_posts) : ?>
                        <div class="related_posts">
                            <h4 class="block-title">Related posts</h4>
                            <div class="row">
                                <?php foreach ($related_posts as $post) : ?>
                                <article class="col-md-4">
                                    <div class="inner">
                                        <div class="post-thumbnail">
                                            <a href="<?php echo site_url("blog/".$post["alias"]."-".$post["id"]); ?>">
                                                <img src="<?php echo base_url()."images/blog/items/".$post["id"]."_900.".$post["image"]; ?>">
                                            </a>
                                        </div>
                                        <div class="post-content">
                                            <a class="post-category" href="<?php echo site_url("blog/".$post["cat_alias"]); ?>"><?php echo $post["cat_name"]; ?></a>
                                            <h5 class="post-title">
                                                <a href="<?php echo site_url("blog/".$post["alias"]."-".$post["id"]); ?>"><?php echo $post["title"]; ?></a>
                                            </h5>
                                        </div>
                                    </div>
                                </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- /related_posts -->
                        <?php endif; ?>
					</div>
				</article>
                <!-- /article -->
			</div>
			<aside class="col-md-3">
                <?php $this->load->view('pc/sidebar'); ?>
            </aside>
		</div>
	</div>
</section>
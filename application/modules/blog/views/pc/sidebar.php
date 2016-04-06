<?php if ($recent_posts && count($recent_posts) > 0) : ?>
<div class="widget-block">
	<h3 class="widget-title">Recent posts</h3>
	<div class="recent-posts">
		<?php foreach ($recent_posts as $post) : ?>
		<article class="post">
			<div class="post-inner-table">
				<div class="post-table-cell">
					<a href="<?php echo site_url("blog/detail/".$post["id"])?>" class="post-thumbnail">
						<img src="<?php echo base_url()."images/blog/items/".$post["id"]."_100.".$post["image"]; ?>" alt="<?php echo $post["title"]; ?>" />
					</a>
				</div>
				<div class="post-table-cell">
					<div class="post-content">
						<a href="" class="post-title"><?php echo $post["title"]; ?></a>
						<div class="post-meta">
							<span>
								<i class="fa fa-calendar"></i>
								<?php echo date('d M, Y', strtotime($post["published_date"])); ?>
							</span>
							<span>
								<i class="fa fa-comments-o"></i>
								123
							</span>
						</div>
					</div>
				</div>
			</div>
		</article>
		<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>
<?php
$blogArgs = array(
  'post_type'           => 'post',
  'posts_per_page'      => 3,
);
//$blogs = new WP_Query($blogArgs);
$blogs = get_sub_field('featured_blog_posts');
?>

<section id="module-<?php echo $i; ?>" class="news-module">
	<div class="max-width flex-padding">

		<div class="news-module-header">
					
			<h2> Sol Systems Blog</h2>
			<a class="view-all with-arrow" href="/newsroom/blog/">View All</a>

		</div>
					
		<div class="flex-container news-posts">
			<?php if( $blogs ): ?>
				<?php foreach( $blogs as $post): $arrow=""; // variable must be called $post (IMPORTANT) ?>
				    <div class="flex-col flex-1-3 news-item">							
					    <?php setup_postdata($post); ?>
					    <?php include ('news_item.php'); ?>
				    </div>
				<?php endforeach; ?>
			<?php endif; ?>
										
		</div>
	</div>
</section>
<?php wp_reset_postdata(); ?>
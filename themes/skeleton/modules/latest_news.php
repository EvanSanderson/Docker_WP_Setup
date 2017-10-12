<?php $newsArgs = array(
  'post_type'           => array('news','post'),
  'posts_per_page'      => 3,
);
$news = new WP_Query($newsArgs);
?>
<section id="module-<?php echo $i; ?>" class="news-module">
	<div class="flex-container news-posts max-width flex-padding">

		<?php while ( $news->have_posts() ) : $news->the_post();  $arrow=""; ?>

			<div class="flex-col flex-1-3 news-item">
				<?php include ('news_item.php'); ?>
			</div>

		<?php endwhile; ?>
						
	</div>
</section>
<?php wp_reset_query(); ?>
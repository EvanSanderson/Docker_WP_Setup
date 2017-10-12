<?php 
$eventsArgs = array(
  'post_type'           => 'events',
  'posts_per_page'      => 3,
);
//$events = new WP_Query($eventsArgs);
$events = get_sub_field('featured_events');
?>

<section id="module-<?php echo $i; ?>" class="news-module darkprimary-bg">
	<div class="max-width flex-padding">

		<div class="news-module-header">
					
			<h2> Sol Systems Events</h2>
			<a class="view-all with-arrow" href="/newsroom/events/">View All</a>

		</div>
					
		<div class="flex-container news-posts">

			<?php if( $events ): ?>
				<?php foreach( $events as $post): $arrow=""; // variable must be called $post (IMPORTANT) ?>
				    <div class="flex-col flex-1-3 news-item">							
					    <?php setup_postdata($post); ?>
					    <?php include ('news_item.php'); ?>
				    </div>
				<?php endforeach; ?>
			<?php endif; ?>
						
								
		</div>
	</div>
</section>
<?php wp_reset_query(); ?>
<?php if (get_the_post_thumbnail_url()) { $arrow = "arrow-top "; ?>
	<a href="<?php print get_permalink(); ?>">
		<div class="item-thumb" style="background:url('<?php print get_the_post_thumbnail_url(); ?>') no-repeat center center;background-size:cover;">
		</div>
	</a>
<?php } ?>

<div class="news-teaser <?php echo $arrow; echo $post->post_type.'-item';?>">

	<?php $type = get_post_type_object( $post->post_type ); ?>

	<?php the_title( '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a></h3>' ); ?>

	<div class="entry-content location-details">
		<?php echo get_field('service_provided'); ?><br/>
		<?php echo get_field('city').", ".get_field('state'); ?>
		<span class="location-size"><?php echo get_field('location_size'); ?></span>
	</div>
</div>

<a class="learn-more with-arrow" href="<?php print get_permalink(); ?>">Learn More</a>

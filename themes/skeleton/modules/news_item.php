<?php if ($post->post_type != "events"){ ?>						
	<?php if (get_the_post_thumbnail_url()) { $arrow = "arrow-top "; ?>
		<a href="<?php print get_permalink(); ?>"><div class="item-thumb" style="background:url('<?php print get_the_post_thumbnail_url(); ?>') no-repeat center center;background-size:cover;">
		</div></a>
	<?php } ?>
<?php } ?>

<div class="news-teaser <?php echo $arrow; echo $post->post_type.'-item';?>">

	<?php $type = get_post_type_object( $post->post_type ); ?>
									
	<div class="news-meta">
											
		<span class="news-type"><?php if($type->labels->singular_name == "Post") echo "Blog"; else echo $type->labels->singular_name; ?></span>

		<?php if ($post->post_type != "events"){ ?>
			<span class="news-date"><?php the_author(); ?> | <?php the_time('F d, Y'); ?></span>
		<?php } else { ?>
			<span class="news-date"><?php echo get_field('start_date'); ?></span>
		<?php } ?>

	</div>

	<?php the_title( '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a></h3>' ); ?>
	<?php if ($post->post_type = "events"){ if (get_field('location')) { ?><div class="location-teaser"><?php echo get_field('location'); ?></div><?php } } ?>

	<div class="entry-content">
		<?php echo wp_trim_words(get_the_excerpt(), 20); ?>
	</div>
</div>

<a class="learn-more with-arrow" href="<?php print get_permalink(); ?>">Read More</a>

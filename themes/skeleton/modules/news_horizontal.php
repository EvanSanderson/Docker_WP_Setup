<div id="module-<?php echo $i; ?>" class="news-teaser <?php echo $arrow; echo $post->post_type.'-item';?>">

		<?php $type = get_post_type_object( $post->post_type ); ?>
									
		<div class="news-meta">
											
			<span class="news-type"><?php if($type->labels->singular_name == "Post") echo "Blog"; else echo $type->labels->singular_name; ?></span>
			<?php if ($post->post_type != "events"){ ?>
				<span class="news-date"><?php the_author(); ?> | <?php the_time('F d, Y'); ?></span>
			<?php } else { ?>
					<span class="news-date"><?php echo get_field('start_date'); ?></span>
			<?php } ?>
		</div>
		<?php $link = get_permalink(); $target=""; 
		if ($post->post_type == "awards" || $post->post_type == "in_the_news"){
			$link = get_field("link");
			$target="_blank";
			} ?>
		<?php the_title( '<h3 class="entry-title"><a target="'.$target.'" href="' . $link . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a></h3>' ); ?>

		<div class="entry-content">
			<?php if ($i==1) echo wp_trim_words(get_the_excerpt(), 50); else echo wp_trim_words(get_the_excerpt(), 20); ?>
		</div>
</div>

<a target="<?php echo $target; ?>" class="learn-more with-arrow" href="<?php print $link; ?>">Read More</a>
<?php wp_reset_query(); ?>
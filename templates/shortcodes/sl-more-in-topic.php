<?php
global $post;
$topic = SL_Helper::get_primary_topic( get_the_ID() );

if( $topic ) : 
$args = array(
    'category' => $topic->term_id,
    'post_status' => 'publish',
    'numberposts' => 4,
	'exclude' => get_the_ID(),
);
if( $more_posts ) :
$more_posts = get_posts($args);
?>
	<div class="sl-more-in-topic-wrapper">
	

		<h2 class="sl-more-in-topic-title">More in <?php echo $topic->name; ?></h2>
	
		<div class="row">
		<?php foreach($more_posts as $more_post) : ?>

				<div class="sl-box-post three columns matchheight">
					<span class="sl-border-hover"></span>
					<div class="sl-feat-img">
						<a href="<?php echo get_the_permalink( $more_post->ID ); ?>"><?php echo get_the_post_thumbnail($more_post); ?></a>
					</div>
					<div class="sl-box">
						<div class="sl-like-button"><?php SL_Helper::the_like_button($more_post->ID); ?></div>
						 <?php if(SL_Helper::get_primary_topic($more_post->ID)) : ?>
							<a href="<?php echo get_term_link( SL_Helper::get_primary_topic($more_post->ID) ); ?>" class="sl-topic-cat"><?php echo SL_Helper::get_primary_topic($more_post->ID)->name; ?></a>
						<?php endif; ?>
						<h6 class="sl-title"><a href="<?php echo get_the_permalink($more_post->ID); ?>"><?php echo get_the_title($more_post->ID); ?></a></h6>
						<a href="<?php echo get_author_posts_url($more_post->post_author) ?>">
                        <span class="sl-author">
                            <?php echo __( 'By: ', 'streetleverage-tools' ) . get_userdata($more_post->post_author)->display_name; ?>
                        </span>
						</a>
						<span class="sl-content-type"><?php // echo get_post_type($more_post); ?></span>
					</div>
				</div>

		<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>
<?php endif; ?>
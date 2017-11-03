<?php
global $post;
$topics = get_the_terms( $post, "category" );
$additional_authors = get_field("additional-authors");

?>

<div class="sl-post-title">
    <?php if( $topics && get_post_type() != 'events' ): ?>
        <div class="topic-holder">
	        <?php foreach($topics as $topic): ?>
            <a href="<?php echo get_term_link($topic); ?>" class="sl-topic orange button"><?php echo $topic->name ?></a>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <h1 class="sl-title"><?php echo get_the_title(); ?></h1>
    <div class="sl-post-author">
    <a href="<?php echo get_author_posts_url($post->post_author) ?>">By: 
    <?php echo get_the_author(); ?></a><?php 
    if ($additional_authors) : 
        foreach($additional_authors as $additional_author) :
            echo ', '; ?>
            <a href="<?php echo get_author_posts_url($additional_author['ID']); ?>">
            <?php echo $additional_author["display_name"]; ?>
            </a><?php
        endforeach;
    endif; 
    ?></div>
    <div class="sl-date-published"><?php echo get_the_date(); ?></div>

</div>

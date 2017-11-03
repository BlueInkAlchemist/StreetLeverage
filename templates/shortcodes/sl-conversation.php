<?php if(file_exists(ABSPATH . 'wp-content/plugins/wpdiscuz/templates/comment/comment-form.php')): ?>
    <?php if( comments_open( ) ): ?>
        <h2>Conversation</h2>
        <?php include_once ABSPATH . 'wp-content/plugins/wpdiscuz/templates/comment/comment-form.php'; ?>
    <?php endif; ?>
<?php endif; ?>

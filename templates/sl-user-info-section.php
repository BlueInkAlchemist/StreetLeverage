<?php
$acf_id = 'user_';
$acf_id .= $userid;
$user = get_userdata($userid);
$usermeta = get_user_meta($userid);
$useremail = get_field( 'public_email', $acf_id );
$userfacebook = get_field( 'facebook_url', $acf_id );
$usertwitter = get_field( 'twitter_url', $acf_id );
$userinstagram = get_field( 'instagram_url', $acf_id );
$username = $user->user_login; 

?>

<div class="sl-user-info sl-box-post">
    <div class="sl-feat-img" style="background-image: url('<?php echo get_avatar_url( $userid, array( 'size' => 300 ) ); ?>'); background-repeat: no-repeat; background-size: cover; background-position: top center">
        <img src="<?php echo get_avatar_url( $userid, array( 'size' => 300 ) ); ?>" style="visibility:hidden;" />
    </div>
    <div class="sl-box">
	    <h4 class="sl-title"><a href="<?php echo get_author_posts_url( $user, $username ) ?>"><?php echo $user->display_name; ?></a></h4>
    <div class="sl-user-bio"><?php echo get_user_meta( $userid, 'description' )[0]; ?></div>
    
    <div class="sl-user-social-links">
        <?php if( $useremail ) : ?>
            <!--<a href="mailto:<?php $socialmedia["Email"] ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a>-->
            <a href="mailto:<?php echo $useremail; ?>" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i></a>
        <?php endif; ?>
        <?php if( $userfacebook ) : ?>
            <!--<a href="<?php $socialmedia["Facebook"] ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>-->
            <a href="<?php echo $userfacebook; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        <?php endif; ?>
        <?php if( $usertwitter ) : ?>
            <!--<a href="<?php $socialmedia["Twitter"] ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>-->
            <a href="<?php echo $usertwitter; ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
        <?php endif; ?>
        <?php if( $userinstagram ) : ?>
            <!--<a href="<?php $socialmedia["Instagram"] ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>-->
            <a href="<?php echo $userinstagram; ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        <?php endif; ?>
    </div>
    </div>
</div>

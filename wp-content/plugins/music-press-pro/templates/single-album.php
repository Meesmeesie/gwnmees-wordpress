<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();
$album_lyric =get_option('options_album_lyric','yes');
$album_comment =get_option('options_album_comment','yes');
$album_player =get_option('options_global_music_player','jplayer');
?>
<div class="mp mp-single album wrap">
    <div class="album-info">
    <?php
    while ( have_posts() ) : the_post();
        /*  Set View Album   */
        music_press_pro_setPostViews(get_the_ID());
        if( has_post_thumbnail() ){
            ?>
            <div class="mp-image">
                <?php the_post_thumbnail('large');?>
            </div>
            <?php
        }
    endwhile; ?>

    <div class="mp-info">
        <div class="mp-album-title">
            <h1 class="mp-name">
                <?php the_title();?>
            </h1>
            <div class="mp-jp-title-tool">
	            <?php
	            /*  Count Play  */
	            $count_play = intval(music_press_pro_getPostViews(get_the_ID()));
	            if( $count_play > 0 ){ ?>
                    <span class="mp-count">
                        <i class="fa fa-headphones" aria-hidden="true"></i>
                        <span><?php echo esc_html(number_format($count_play));?></span>
                    </span>
	            <?php } ?>
	            <?php
	            $enableshare = get_option('options_global_share', 'enable');
	            if($enableshare == 'enable'):
		            ?>
                    <div class="btn-group jp-share jp-share__album">
                        <a href="#" class="btn btn-default jp-share__button">
                            <i class="fa fa-share-alt" aria-hidden="true"></i>
				            <?php echo esc_html__('Share','music-press-pro'); ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="http://twitter.com/home?status=Check+this+out%3A+<?php the_permalink(); ?>"
                                   title="Share <?php the_title(); ?> on Twitter">
						            <?php echo esc_html__('Share on Twitter','music-press-pro'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"
                                   title="Add <?php the_title(); ?> to Google Plus">
						            <?php echo esc_html__('Add to Google+','music-press-pro'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=Check+this+out"
                                   title="Share <?php the_title(); ?> on Facebook">
						            <?php echo esc_html__('Share on Facebook','music-press-pro'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
	            <?php endif; ?>
            </div>

        </div>
        <div class="mp-genres">
            <?php
            do_action('music_press_pro_album_genre');
            ?>
        </div>
        <div class="mp-band">
            <?php
            do_action('music_press_pro_album_band');
            ?>
        </div>
        <div class="mp-artist">
            <?php
            do_action('music_press_pro_album_artist');
            ?>
        </div>
        <?php
        while ( have_posts() ) : the_post();
            ?>
            <div class="mp-description">
                <?php the_content();?>
            </div>
            <?php
        endwhile;
        ?>
    </div>
        <div class="clr"></div>
    </div>

<?php
//do_action('music_press_pro_album_length');
if($album_player=='wavesurfer'){
    do_action('music_press_pro_album_wave_player');
}else{
    $album_type = get_field('album_type',get_the_ID());
    if($album_type=='audio' ){
        do_action('music_press_pro_album_player');
    }elseif($album_type=='video'){
        do_action('music_press_pro_album_video_player');
    }else{
        do_action('music_press_pro_album_all_player');
    }
    if($album_lyric=='yes'){
        do_action('music_press_pro_album_lyric');
    }
}

if($album_comment=='yes'){
?>
    <div class="mp-comments">
        <?php comments_template('',true); ?>
    </div>

<?php
}
?>
</div>
<?php
do_action( 'music_press_pro_sidebar' );
get_footer();

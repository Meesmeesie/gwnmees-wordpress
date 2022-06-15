<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
wp_enqueue_style('music-press-jplayer-blue');
wp_enqueue_script('music-press-jquery.jplayer');
global $post;
$songID = $post->ID;
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$song_type = get_field('song_type',$songID );
$autoplay = 'yes';

if (class_exists('MusicPressMember')) {
    $song_wishlist = music_press_pro_get_songs_wishlist($songID);
    if ($song_wishlist == 'in_wishlist') {
        $wishlist_text = __('in wishlist', 'music-press-pro');
    } else {
        $wishlist_text = __('Add', 'music-press-pro');
    }
}
?>
<div id="jp_container_1" class="jp-video jp-video-360p" role="application" aria-label="media player">
    <div class="jp-type-single">
        <div class="jp-playlist-head">
            <div id="music_press_video" class="jp-jplayer"></div>
            <div class="jp-gui">
                <div class="jp-video-play">
                    <button class="jp-video-play-icon" role="button" tabindex="0"><i class="play fa fa-play"></i></button>
                </div>
                <div class="jp-interface">
                    <div class="jp-controls">
                        <button class="jp-play" role="button" tabindex="0"><i class="play fa fa-play"></i><i class="pause fa fa-pause"></i></button>
                        <button class="jp-stop" role="button" tabindex="0"><i class="fa fa-stop"></i></button>
                    </div>
                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                    </div>
                    <div class="jp-timer">
                        <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                        <span class="jp-line">/</span>
                        <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                    </div>
                    <div class="jp-toggles">
                        <button class="jp-repeat" role="button" tabindex="0"><i class="fa fa-repeat"></i></button>
                        <button class="jp-full-screen" role="button" tabindex="0"><i class="fa fa-arrows-alt"></i></button>
                    </div>
                    <div class="jp-volume-controls">
                        <button class="jp-mute" role="button" tabindex="0"><i class="off fa fa-volume-off"></i><i class="down fa fa-volume-down"></i></button>
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>
                        <button class="jp-volume-max" role="button" tabindex="0"><i class="fa fa-volume-up"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="jp-details">
            <div class="jp-title" aria-label="title">&nbsp;</div>
		    <?php
		    $enableshare = get_option('options_global_share', 'enable');
		    $count_play = intval(music_press_pro_getPostViews($songID));
		    if ($enableshare == 'enable' || class_exists('MusicPressMember') || $count_play > 0): ?>
                <div class="mp-jp-title-tool">
	                <?php
	                /*  Count Play  */
	                if ($count_play > 0) { ?>
                        <span class="mp-count">
                            <i class="fa fa-headphones" aria-hidden="true"></i>
                            <span><?php echo esc_html(number_format($count_play)); ?></span>
                        </span>
	                <?php } ?>

	                <?php
	                if (class_exists('MusicPressMember')) {
		                ?>
                        <div class="mp_song_add">
                            <span class="mp_add_to"><i class="fa fa-plus"></i> <?php echo esc_html_e('Add to', 'music-press-pro'); ?></span>
                            <div class="mp_box_add">
                                <h4><?php echo esc_html_e('Add to playlist', 'music-press-pro') ?></h4>
                                <div class="mp_song_wishlist">
                                    <div class="mp_list_songs">
                                        <p><?php echo esc_html_e('Song wishlist', 'music-press-pro') ?></p>
                                        <span song_id="<?php echo $songID; ?>" class="mp_btn_add_song">
                                            <?php echo $wishlist_text; ?>
                                        </span>
                                        <div class="clr"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

	                <?php if($enableshare == 'enable'): ?>
                        <div class="btn-group jp-share jp-share__detail">
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
            <?php endif; ?>
        </div>
        <div class="jp-no-solution">
            <span>Update Required</span>
            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
        </div>
    </div>
</div>
<script type="text/javascript">
    <?php
    if(get_field('song_video')){
        $file = get_field('song_video');
    }
    if(get_field('song_video_cover')){
        $file = get_field('song_video_cover');
    }
    if( $file ) {
        $url = wp_get_attachment_url($file);
    }else {
        $url = get_field('song_video_link');
    }
    ?>
    //<![CDATA[
    jQuery(document).ready(function(){

        jQuery("#music_press_video").jPlayer({
            ready: function () {
                jQuery(this).jPlayer("setMedia", {
                    title: "<?php echo esc_attr(get_the_title($songID));?>",
                    m4v: "<?php echo esc_url($url);?>",
                    poster: "<?php the_post_thumbnail_url( 'full' );?>"
                })<?php if($autoplay=='yes'){ ?>.jPlayer("play") <?php }?>;
            },
            swfPath: "<?php echo esc_url(MUSIC_PRESS_PRO_PLUGIN_URL.'/assets/js');?>",
            supplied: "webmv, ogv, m4v",
            size: {
                width: "100%",
                height: "auto",
                cssClass: "jp-video-360p"
            },
            useStateClassSkin: true,
            autoBlur: false,
            smoothPlayBar: true,
            keyEnabled: true,
            remainingDuration: true,
            toggleDuration: true
        });

        jQuery('.jp-share__button').on('click', function (event) {
           event.preventDefault();
        });

    });
    //]]>
</script>
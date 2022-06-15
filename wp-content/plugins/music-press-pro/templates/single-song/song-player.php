<?php
if (!defined('ABSPATH')) {
    exit;
}
wp_enqueue_style('music-press-jplayer-blue');
wp_enqueue_script('music-press-jquery.jplayer');
global $post;
$songID = $post->ID;
$autoplay = 'yes';
?>
<div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
    <div class="jp-type-single">
        <div class="jp-playlist-head">
            <div id="music_press_audio_player" class="jp-jplayer"></div>
            <div class="jp-gui jp-interface">
                <div class="jp-controls">
                    <button class="jp-play" role="button" tabindex="0"><i class="play fa fa-play"></i><i
                                class="pause fa fa-pause"></i></button>
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
                </div>
                <div class="jp-volume-controls">
                    <button class="jp-mute" role="button" tabindex="0"><i class="off fa fa-volume-off"></i><i
                                class="down fa fa-volume-down"></i></button>
                    <div class="jp-volume-bar">
                        <div class="jp-volume-bar-value"></div>
                    </div>
                    <button class="jp-volume-max" role="button" tabindex="0"><i class="fa fa-volume-up"></i></button>
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
				        do_action('music_press_member_action_add_song_playlist');
					     } ?>

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
            To play the media you will need to either update your browser to a recent version or update your <a
                    href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        <?php
        if (get_field('song_audio')) {
            $file = get_field('song_audio');
        }
        if (get_field('song_audio_cover')) {
            $file = get_field('song_audio_cover');
        }
        if ($file) {
            $url = wp_get_attachment_url($file);
        } else {
            $url = get_field('song_audio_link');
        }
        ?>
        jQuery("#music_press_audio_player").jPlayer({
            ready: function (event) {
                jQuery(this).jPlayer("setMedia", {
                    title: "<?php echo esc_attr(get_the_title($songID));?>",
                    m4a: "<?php echo esc_url($url);?>",
                    poster: "<?php the_post_thumbnail_url('full');?>"
                })<?php if($autoplay == 'yes'){ ?>.jPlayer("play") <?php }?>;
            },
            swfPath: "<?php echo esc_url(MUSIC_PRESS_PRO_PLUGIN_URL . 'assets/js');?>",
            supplied: "m4a, oga",
            size: {
                width: "100%",
                height: "auto",
                cssClass: "jp-song-audio"
            },
            wmode: "window",
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
</script>
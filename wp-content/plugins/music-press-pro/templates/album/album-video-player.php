<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$autoplay =get_option('options_album_autoplay','yes');
$orderby =get_option('options_album_orderby','post_date');
$order =get_option('options_album_order','DESC');
$download =get_option('options_global_download','true');
global $post, $wpdb;
$albumID = $post->ID;
$song_arr = music_press_pro_get_songs_from_album($albumID,$orderby,$order);

/*  Check Song Source   */
$has_embed = $has_upload = false;
foreach ($song_arr as $song_ID){
    $file_source = get_field('song_source',$song_ID);
    if( $file_source != 'embed' ){
        $has_upload = true;
    }
    if( $file_source == 'embed' ){
        $has_embed = true;
    }
}

if($has_upload){
    wp_enqueue_style('music-press-jplayer-blue');
    wp_enqueue_script('music-press-jquery.jplayer');
    wp_enqueue_script('music-press-jquery.jplayerlist');

?>
<div class="mp_playlist video">
    <div id="jp_container_1" class="jp-video jp-video-270p" role="application" aria-label="media player">
        <div class="jp-type-playlist">
            <div class="jp-playlist-head">
                <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                <div class="jp-gui">
                    <div class="jp-video-play">
                        <button class="jp-video-play-icon" role="button" tabindex="0"><i class="play fa fa-play"></i></button>
                    </div>
                    <div class="jp-interface">
                        <div class="jp-controls">
                            <button class="jp-stop" role="button" tabindex="0"><i class="fa fa-stop"></i></button>
                            <button class="jp-previous" role="button" tabindex="0"><i class="fa fa-step-backward"></i>
                            </button>
                            <button class="jp-play" role="button" tabindex="0"><i class="play fa fa-play"></i><i class="pause fa fa-pause"></i></button>
                            <button class="jp-next" role="button" tabindex="0"><i class="fa fa-step-forward"></i>
                            </button>
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
                            <button class="jp-shuffle" role="button" tabindex="0"><i class="fa fa-random"></i></button>
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
            </div>
            <div class="jp-playlist">
                <ul>
                    <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                    <li>&nbsp;</li>
                </ul>
            </div>
            <div class="jp-no-solution">
                <span>Update Required</span>
                To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function () {

        new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer_1",
            cssSelectorAncestor: "#jp_container_1"
        }, [
            <?php if ( $song_arr ) :
                $mp_count = 1;
            foreach ($song_arr as $song){
                $file_type = get_field('song_type',$song);
                if($file_type=='video'){
                    $mp_count_item = $mp_count;
                    if( $mp_count < 10 ){
                        $mp_count_item = '0'.$mp_count;
                    }

                    if(get_field('song_video',$song)){
                        $file = get_field('song_video',$song);
                    }
                    if(get_field('song_video_cover',$song)){
                        $file = get_field('song_video_cover',$song);
                    }

                    $artists = get_field('song_artist',$song);
                    if($artists != null){
                        $count = count($artists);
                        $i=1;
                        $song_artist='';
                        foreach ($artists as $artist){
                            if($i== $count){
                                $song_artist .= get_the_title($artist);
                            }else{
                                $song_artist .= get_the_title($artist). esc_html__(', ', 'music-press-pro');
                            }
                            $i++;
                        }
                    }
                    if($file){
                        $url = wp_get_attachment_url( $file );
                    }else{
                        $url = get_field('song_video_link',$song);
                    }

                    ?>
                    {
                        title:  "<?php echo '<span>'. esc_html($mp_count_item) .'.<span></span></span>'.esc_attr(get_the_title($song));?>",
                        artist:"<?php echo esc_attr($song_artist);?>",
                        m4v: "<?php echo esc_url($url);?>",
                        download:<?php echo esc_attr($download); ?>,
                        free:true,
                        songID:"<?php echo esc_attr($song);?>",
                        icondownload:"fa-download",
                        urldl:"<?php echo esc_url(get_permalink($file));?>",
                        file_id:"<?php echo esc_attr($file);?>",
                        poster:"<?php the_post_thumbnail_url( 'full' );?>"
                    },
                    <?php
                    $mp_count ++;
                }
            } endif;?>
        ], {
            <?php if($autoplay=='yes'){
                ?>playlistOptions: {
                autoPlay: true
            },
            <?php }?>
            swfPath: "<?php echo esc_url(MUSIC_PRESS_PRO_PLUGIN_URL.'/assets/js');?>",
            supplied: "webmv, ogv, m4v",
            size: {
                width: "100%",
                height: "auto",
                cssClass: "album-video"
            },
            useStateClassSkin: true,
            autoBlur: false,
            smoothPlayBar: true,
            keyEnabled: true
        });
    });
    //]]>
</script>
<?php
}
if( $has_embed ){
    do_action('music_press_pro_album_video_embed');
}
?>
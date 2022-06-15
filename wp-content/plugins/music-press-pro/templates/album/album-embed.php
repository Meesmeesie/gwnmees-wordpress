<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$autoplay =get_option('options_album_autoplay','yes');
$image_player =get_option('options_album_image_player','image_album');
$orderby =get_option('options_album_orderby','post_date');
$order =get_option('options_album_order','DESC');
global $post, $wpdb;
$albumID = $post->ID;
$album_imageID = get_field( 'album_poster',$albumID);
if(isset($album_imageID)){
    $album_image =  wp_get_attachment_url( $album_imageID );
}else{
    $album_image='';
}

$song_arr = music_press_pro_get_songs_from_album($albumID,$orderby,$order);

?>
<div class="mp_playlist audio">
    <div id="player"></div>
</div>

<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function () {
        // 2. This code loads the IFrame Player API code asynchronously.
        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // 3. This function creates an <iframe> (and YouTube player)
        //    after the API code downloads.
        var player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '390',
                width: '640',
                playerVars: {
                    autoplay: 1,
                    cc_load_policy: 0, /*Show(1)-hide(0) Caption*/
                    controls: 1,
                    enablejsapi: 1,
                    hl: 'en', /*Change Language http://www.loc.gov/standards/iso639-2/php/code_list.php*/
                    fs: 1, /*Show(1)-hide(0) button Fullscreen*/
                    iv_load_policy: 3, /*Show(1)-hide(3) annotations*/
                    loop: 1,
                    modestbranding: 1, /*Show(0)-hide(1) annotations YouTube logo*/
                    playlist: 'nuKrLe9gQQs,MEWZcsqxAcU,-SZNP33hyBA',
                    playsinline: 1,
                    rel: 0,  /*Show(1)-hide related videos*/
                    showinfo: 1 /*Show(1)-hide information*/
                },
                events: {
                    'onStateChange': function(e) {
                        if (e.data == 0) {
                            //skrolla här
                        }
                    }
                }
            });
        }
    });
    //]]>
</script>
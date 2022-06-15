<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$autoplay =get_option('options_album_autoplay','yes');
$orderby =get_option('options_album_orderby','post_date');
$order =get_option('options_album_order','DESC');
global $post, $wpdb;
$albumID = $post->ID;
$song_arr = music_press_pro_get_songs_from_album($albumID,$orderby,$order);

$song_playlist = '';
if($song_arr){
    $mp_count = 1;
    foreach ($song_arr as $song){
        $song_source = get_field('song_source',$song);
        if( $song_source == 'embed' ){
            $song_embed = get_field('song_embed_video',$song);
            if( $mp_count == 1 ){
                $song_playlist .= music_press_pro_YouTubeGetID( $song_embed );
            }else{
                $song_playlist .= ','.music_press_pro_YouTubeGetID( $song_embed );
            }
            $mp_count++;
        }
    }
}

if( !empty($song_playlist) ){
?>
<div class="mp_playlist video">
    <div id="player"></div>
</div>

<script type="text/javascript">
    //<![CDATA[
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
                height: '450',
                width: '800',
                playerVars: {
                    autoplay: 0,
                    cc_load_policy: 0, /*Show(1)-hide(0) Caption*/
                    controls: 1,
                    enablejsapi: 1,
                    hl: 'en', /*Change Language http://www.loc.gov/standards/iso639-2/php/code_list.php*/
                    fs: 1, /*Show(1)-hide(0) button Fullscreen*/
                    iv_load_policy: 3, /*Show(1)-hide(3) annotations*/
                    loop: 1,
                    modestbranding: 1, /*Show(0)-hide(1) annotations YouTube logo*/
                    playlist: '<?php echo esc_html($song_playlist); ?>',
                    playsinline: 1,
                    rel: 0,  /*Show(1)-hide related videos*/
                    showinfo: 1 /*Show(1)-hide information*/
                },
                events: {
                    'onStateChange': function(e) {
//                        if (e.data == 0) {
                            //skrolla här
//                        }
                    }
                }
            });
        }
    //]]>
</script>

<?php
}
?>
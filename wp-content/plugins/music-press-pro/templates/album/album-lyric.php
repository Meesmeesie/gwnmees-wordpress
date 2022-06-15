<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$orderby =get_option('options_album_orderby','post_date');
$order =get_option('options_album_order','DESC');
global $post;
$albumID = $post->ID;
$song_arr = music_press_pro_get_songs_from_album($albumID,$orderby,$order);
if($song_arr ){
    $first_songID = $song_arr[0];
    if(get_field('song_lyric',$first_songID)){
    ?>
    <div class="mp-lyric">
        <h3><?php echo esc_html__('Lyrics', 'music-press-pro');?></h3>
        <div class="song-lyric">
            <?php
            echo balanceTags(get_field('song_lyric',$first_songID));
            ?>
        </div>
    </div>
<?php
    }
}else{
    echo esc_html__('No song in album', 'music-press-pro');
}
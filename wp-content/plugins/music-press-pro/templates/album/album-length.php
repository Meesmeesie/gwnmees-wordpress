<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once( ABSPATH . 'wp-admin/includes/media.php' );
$orderby =get_option('options_album_orderby','post_date');
$order =get_option('options_album_order','DESC');
global $post, $wpdb;
$albumID = $post->ID;
$song_arr = music_press_pro_get_songs_from_album($albumID,$orderby,$order);

if($song_arr ){
    $music_total = 0;
    foreach ($song_arr  as $song){
        $music_file_type = get_field('song_type',$song);
        if ($music_file_type == 'audio') {
            if (get_field('song_audio', $song)) {
                $music_file = get_field('song_audio', $song);
            }
            if (get_field('song_audio_cover', $song)) {
                $music_file = get_field('song_audio_cover', $song);
            }
        }
        if ($music_file_type == 'video') {
            if (get_field('song_video', $song)) {
                $music_file = get_field('song_video', $song);
            }
            if (get_field('song_video_cover', $song)) {
                $music_file = get_field('song_video_cover', $song);
            }
        }
        if ($music_file) {
            $music_url = get_attached_file($music_file);
            $metadata  = wp_read_audio_metadata($music_url );
            $duration_song = $metadata['length'];
            $music_total += $duration_song;
        }
    }
    $hours = floor($music_total / 3600);
    $minutes = floor( ($music_total - ($hours * 3600)) / 60);
    $seconds = $music_total - ($hours * 3600) - ($minutes * 60);
    if ($hours >= 1):
        echo esc_html($hours) . ' ' . esc_html__('Hour',  'music-press-pro');
    endif;
    echo esc_html__(" ", 'music-press-pro');
    echo esc_html($minutes) . ' ' . esc_html__('Minutes',  'music-press-pro');
}
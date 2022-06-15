<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Song.
 *
 * @see music_press_pro_display_song_player()
 */
add_action('music_press_pro_song_embed','music_press_pro_display_song_embed',10);
add_action('music_press_pro_song_video_embed','music_press_pro_display_song_video_embed',10);
add_action('music_press_pro_song_player','music_press_pro_display_song_player',10);
add_action('music_press_pro_song_video_player','music_press_pro_display_song_video_player',10);
add_action('music_press_pro_song_album','music_press_pro_display_song_albums',10);
add_action('music_press_pro_song_genre','music_press_pro_display_song_genres',10);
add_action('music_press_pro_song_artist','music_press_pro_display_song_artists',10);
add_action('music_press_pro_song_band','music_press_pro_display_song_bands',10);
add_action('music_press_pro_song_wave_player','music_press_pro_display_song_wave_player',10);

add_action('music_press_pro_album_embed','music_press_pro_display_album_embed',10);
add_action('music_press_pro_album_video_embed','music_press_pro_display_album_video_embed',10);
add_action('music_press_pro_album_player','music_press_pro_display_album_player',10);
add_action('music_press_pro_album_video_player','music_press_pro_display_album_video_player',10);
add_action('music_press_pro_album_all_player','music_press_pro_display_album_all_player',10);
add_action('music_press_pro_album_length','music_press_pro_display_album_length',10);
add_action('music_press_pro_album_lyric','music_press_pro_display_album_lyric',10);
add_action('music_press_pro_album_genre','music_press_pro_display_album_genres',10);
add_action('music_press_pro_album_artist','music_press_pro_display_album_artists',10);
add_action('music_press_pro_album_band','music_press_pro_display_album_bands',10);
add_action('music_press_pro_album_wave_player','music_press_pro_display_album_wave_player',10);

add_action('music_press_pro_genre_list_audio','music_press_pro_display_genre_song_audio',10);
add_action('music_press_pro_genre_list_video','music_press_pro_display_genre_song_video',10);
add_action('music_press_pro_genre_list_album','music_press_pro_display_genre_album',10);
add_action('music_press_pro_genre_list_all_songs','music_press_pro_display_genre_all_songs',10);
add_action('music_press_pro_genre_list_all_videos','music_press_pro_display_genre_all_videos',10);
add_action('music_press_pro_genre_list_all_albums','music_press_pro_display_genre_all_albums',10);

add_action('music_press_pro_artist_list_audio','music_press_pro_display_artist_song_audio',10);
add_action('music_press_pro_artist_list_video','music_press_pro_display_artist_song_video',10);
add_action('music_press_pro_artist_list_album','music_press_pro_display_artist_album',10);
add_action('music_press_pro_artist_list_all_songs','music_press_pro_display_artist_all_songs',10);
add_action('music_press_pro_artist_list_all_videos','music_press_pro_display_artist_all_videos',10);
add_action('music_press_pro_artist_list_all_albums','music_press_pro_display_artist_all_albums',10);

add_action('music_press_pro_band_list_audio','music_press_pro_display_band_song_audio',10);
add_action('music_press_pro_band_list_video','music_press_pro_display_band_song_video',10);
add_action('music_press_pro_band_list_album','music_press_pro_display_band_album',10);
add_action('music_press_pro_band_list_all_songs','music_press_pro_display_band_all_songs',10);
add_action('music_press_pro_band_list_all_videos','music_press_pro_display_band_song_all_videos',10);
add_action('music_press_pro_band_list_all_members','music_press_pro_display_band_song_all_members',10);
add_action('music_press_pro_band_list_all_albums','music_press_pro_display_band_all_albums',10);

add_action( 'music_press_pro_sidebar', 'music_press_pro_get_sidebar', 10 );

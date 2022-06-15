<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


if ( ! function_exists( 'music_press_pro_display_song_embed' ) ) {

    /**
     * Output song embed
     *
     */
    function music_press_pro_display_song_embed() {
        mp_get_template( 'single-song/song-embed.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_song_video_embed' ) ) {

    /**
     * Output song Video embed
     *
     */
    function music_press_pro_display_song_video_embed() {
        mp_get_template( 'single-song/song-video-embed.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_song_player' ) ) {

    /**
     * Output song player
     *
     */
    function music_press_pro_display_song_player() {
        mp_get_template( 'single-song/song-player.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_song_wave_player' ) ) {

    /**
     * Output song player
     *
     */
    function music_press_pro_display_song_wave_player() {
        mp_get_template( 'single-song/song-wave-player.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_song_video_player' ) ) {

    /**
     * Output song Video player
     *
     */
    function music_press_pro_display_song_video_player() {
        mp_get_template( 'single-song/song-video-player.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_song_albums' ) ) {

    /**
     * Output song Albums
     *
     */
    function music_press_pro_display_song_albums() {
        mp_get_template( 'single-song/song_albums.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_song_genres' ) ) {

    /**
     * Output song Genres
     *
     */
    function music_press_pro_display_song_genres() {
        mp_get_template( 'single-song/song_genres.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_song_artists' ) ) {

    /**
     * Output song Artist
     *
     */
    function music_press_pro_display_song_artists() {
        mp_get_template( '/single-song/song_artists.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_song_bands' ) ) {

    /**
     * Output song Bands
     *
     */
    function music_press_pro_display_song_bands() {
        mp_get_template( 'single-song/song_bands.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_album_embed' ) ) {

    /**
     * Output song Bands
     *
     */
    function music_press_pro_display_album_embed() {
        mp_get_template( 'album/album-embed.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_album_video_embed' ) ) {

    /**
     * Output song Bands
     *
     */
    function music_press_pro_display_album_video_embed() {
        mp_get_template( 'album/album-video-embed.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_album_player' ) ) {

    /**
     * Album player
     *
     */
    function music_press_pro_display_album_player() {
        mp_get_template( 'album/album-player.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_album_wave_player' ) ) {

    /**
     * Wave album player
     *
     */
    function music_press_pro_display_album_wave_player() {
        mp_get_template( 'album/album-wave-player.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_album_video_player' ) ) {

    /**
     * Output song Bands
     *
     */
    function music_press_pro_display_album_video_player() {
        mp_get_template( 'album/album-video-player.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_album_all_player' ) ) {

    /**
     * Output song Bands
     *
     */
    function music_press_pro_display_album_all_player() {
        mp_get_template( 'album/album-all-player.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_album_length' ) ) {

    /**
     * Output album length
     *
     */
    function music_press_pro_display_album_length() {
        mp_get_template( 'album/album-length.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_album_lyric' ) ) {

    /**
     * Output album length
     *
     */
    function music_press_pro_display_album_lyric() {
        mp_get_template( 'album/album-lyric.php' );
    }
}
if ( ! function_exists( 'music_press_pro_get_songs_from_album' ) ) {

    /**
     * Output songs ID
     *
     */
    function music_press_pro_get_songs_from_album($albumID,$orderby,$order) {
        global $wpdb;
        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $song_values = "SELECT * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID 
                        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
                        WHERE pm.meta_key ='song_album' AND po.post_status='publish' AND pm.meta_value REGEXP '\"$albumID\"' 
                        ORDER BY ".$orderby." ".$order."";
        $song_results = $wpdb->get_results($song_values );
        $song_arr = array();
        if($song_results){
            foreach ($song_results as $song){
                $album = unserialize($song->meta_value);
                if($album){
                    if($albumID==$album || in_array($albumID, $album)){
                        $song_arr[]=$song->post_id;
                    }
                }
            }
            return $song_arr;
        }
    }
}

if ( ! function_exists( 'music_press_pro_display_album_genres' ) ) {

    /**
     * Output Album Genres
     *
     */
    function music_press_pro_display_album_genres() {
        mp_get_template( 'album/album_genres.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_album_artists' ) ) {

    /**
     * Output Album Genres
     *
     */
    function music_press_pro_display_album_artists() {
        mp_get_template( 'album/album_artists.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_album_bands' ) ) {

    /**
     * Output Album Genres
     *
     */
    function music_press_pro_display_album_bands() {
        mp_get_template( 'album/album_bands.php' );
    }
}

if ( ! function_exists( 'music_press_pro_get_songs_from_genre' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_songs_from_genre($genreID,$limit,$orderby,$order,$type) {
        global $wpdb;
        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $song_values = "SELECT * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID 
                        LEFT JOIN(SELECT meta_key as song_type, meta_value as mptype, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='song_type') as pmm ON pmm.post_id=pm.post_id
                        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
                        WHERE pm.meta_key ='song_genre' AND po.post_status='publish' AND pm.meta_value REGEXP '\"$genreID\"' 
                        AND pmm.song_type ='song_type' AND pmm.mptype ='".$type."' ORDER BY ".$orderby." ".$order." LIMIT ".$limit."";
        $song_results = $wpdb->get_results($song_values );
        $song_arr = array();
        if($song_results){
            foreach ($song_results as $song){
                $genre = unserialize($song->meta_value);
                if($genre){
                    if($genreID==$genre || in_array($genreID, $genre)){
                        $song_arr[]=$song->post_id;
                    }
                }

            }
            return $song_arr;
        }
    }
}
if ( ! function_exists( 'music_press_pro_get_all_songs_from_genre' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_all_songs_from_genre($genreID,$orderby,$order,$type) {
        global $wpdb;
        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $song_values = "SELECT * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID 
                        LEFT JOIN(SELECT meta_key as song_type, meta_value as mptype, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='song_type') as pmm ON pmm.post_id=pm.post_id
                        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
                        WHERE pm.meta_key ='song_genre' AND po.post_status='publish' AND pm.meta_value REGEXP '\"$genreID\"' 
                        AND pmm.song_type ='song_type' AND pmm.mptype ='".$type."' ORDER BY ".$orderby." ".$order."";
        $song_results = $wpdb->get_results($song_values );
        $song_arr = array();
        if($song_results){
            foreach ($song_results as $song){
                $genre = unserialize($song->meta_value);
                if($genre){
                    if($genreID==$genre || in_array($genreID, $genre)){
                        $song_arr[]=$song->post_id;
                    }
                }

            }
            return $song_arr;
        }
    }
}

if ( ! function_exists( 'music_press_pro_get_albums_from_genre' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_albums_from_genre($genreID,$limit,$orderby,$order) {
        global $wpdb;
        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $album_values = "SELECT  * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID
        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
         WHERE pm.meta_key= 'album_genre'  AND po.post_status='publish' AND  pm.meta_value REGEXP '\"$genreID\"' ORDER BY ".$orderby." ".$order." LIMIT ".$limit."";
        $album_results = $wpdb->get_results($album_values );
        $album_arr = array();
        if($album_results){
            foreach ($album_results as $album){
                $ab = unserialize($album->meta_value);
                if($ab){
                    if($genreID==$ab || in_array($genreID, $ab)){
                        $album_arr[]=$album->post_id;
                    }
                }
            }
            return $album_arr;
        }
    }
}
if ( ! function_exists( 'music_press_pro_get_all_albums_from_genre' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_all_albums_from_genre($genreID,$orderby,$order) {
        global $wpdb;
        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $album_values = "SELECT  * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID
        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
         WHERE pm.meta_key= 'album_genre'  AND po.post_status='publish' AND  pm.meta_value REGEXP '\"$genreID\"' ORDER BY ".$orderby." ".$order."";
        $album_results = $wpdb->get_results($album_values );
        $album_arr = array();
        if($album_results){
            foreach ($album_results as $album){
                $ab = unserialize($album->meta_value);
                if($ab){
                    if($genreID==$ab || in_array($genreID, $ab)){
                        $album_arr[]=$album->post_id;
                    }
                }
            }
            return $album_arr;
        }
    }
}

if ( ! function_exists( 'music_press_pro_get_songs_from_artist' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_songs_from_artist($artistID,$limit,$orderby,$order,$type) {
        global $wpdb;

        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $song_values = "SELECT * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID 
                        LEFT JOIN(SELECT meta_key as song_type, meta_value as mptype, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='song_type') as pmm ON pmm.post_id=pm.post_id
                        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
                        WHERE pm.meta_key ='song_artist' AND po.post_status='publish' AND pm.meta_value REGEXP '\"$artistID\"' 
                        AND pmm.song_type ='song_type' AND pmm.mptype ='".$type."' ORDER BY ".$orderby." ".$order." LIMIT ".$limit."";
        $song_results = $wpdb->get_results($song_values );
        $song_arr = array();
        if($song_results){
            foreach ($song_results as $song){
                $artist = unserialize($song->meta_value);
                if($artist){
                    if($artistID==$artist || in_array($artistID, $artist)){
                        $song_arr[]=$song->post_id;
                    }
                }
            }
            return $song_arr;
        }
    }
}
if ( ! function_exists( 'music_press_pro_get_all_songs_from_artist' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_all_songs_from_artist($artistID,$orderby,$order,$type) {
        global $wpdb;

        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $song_values = "SELECT * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID 
                        LEFT JOIN(SELECT meta_key as song_type, meta_value as mptype, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='song_type') as pmm ON pmm.post_id=pm.post_id
                        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
                        WHERE pm.meta_key ='song_artist' AND po.post_status='publish' AND pm.meta_value REGEXP '\"$artistID\"' 
                        AND pmm.song_type ='song_type' AND pmm.mptype ='".$type."' ORDER BY ".$orderby." ".$order." ";
        $song_results = $wpdb->get_results($song_values );
        $song_arr = array();
        if($song_results){
            foreach ($song_results as $song){
                $artist = unserialize($song->meta_value);
                if($artist){
                    if($artistID==$artist || in_array($artistID, $artist)){
                        $song_arr[]=$song->post_id;
                    }
                }
            }
            return $song_arr;
        }
    }
}
if ( ! function_exists( 'music_press_pro_get_songs_from_band' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_songs_from_band($bandID,$limit,$orderby,$order,$type) {
        global $wpdb;
        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $song_values = "SELECT * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID 
                        LEFT JOIN(SELECT meta_key as song_type, meta_value as mptype, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='song_type') as pmm ON pmm.post_id=pm.post_id
                        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
                        WHERE pm.meta_key ='song_band' AND po.post_status='publish' AND pm.meta_value REGEXP '\"$bandID\"' 
                        AND pmm.song_type ='song_type' AND pmm.mptype ='".$type."' ORDER BY ".$orderby." ".$order." LIMIT ".$limit."";
        $song_results = $wpdb->get_results($song_values );
        $song_arr = array();
        if($song_results){
            foreach ($song_results as $song){
                $artist = unserialize($song->meta_value);
                if($artist){
                    if($bandID==$artist || in_array($bandID, $artist)){
                        $song_arr[]=$song->post_id;
                    }
                }
            }
            return $song_arr;
        }
    }
}
if ( ! function_exists( 'music_press_pro_get_all_songs_from_band' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_all_songs_from_band($bandID,$orderby,$order,$type) {
        global $wpdb;
        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $song_values = "SELECT * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID 
                        LEFT JOIN(SELECT meta_key as song_type, meta_value as mptype, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='song_type') as pmm ON pmm.post_id=pm.post_id
                        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
                        WHERE pm.meta_key ='song_band' AND po.post_status='publish' AND pm.meta_value REGEXP '\"$bandID\"' 
                        AND pmm.song_type ='song_type' AND pmm.mptype ='".$type."' ORDER BY ".$orderby." ".$order." ";
        $song_results = $wpdb->get_results($song_values );
        $song_arr = array();
        if($song_results){
            foreach ($song_results as $song){
                $artist = unserialize($song->meta_value);
                if($artist){
                    if($bandID==$artist || in_array($bandID, $artist)){
                        $song_arr[]=$song->post_id;
                    }
                }
            }
            return $song_arr;
        }
    }
}
if ( ! function_exists( 'music_press_pro_get_albums_from_artist' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_albums_from_artist($artistID,$limit,$orderby,$order) {
        global $wpdb;
        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $album_values = "SELECT  DISTINCT * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID
        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
         WHERE pm.meta_key= 'album_artist'  AND po.post_status='publish' AND  pm.meta_value REGEXP '\"$artistID\"' ORDER BY ".$orderby." ".$order." LIMIT ".$limit."";
        $album_results = $wpdb->get_results($album_values );
        $album_arr = array();
        if($album_results){
            foreach ($album_results as $album){
                $ab = unserialize($album->meta_value);
                if($ab){
                    if($artistID==$ab || in_array($artistID, $ab)){
                        $album_arr[]=$album->post_id;
                    }
                }
            }
            return $album_arr;
        }
    }
}
if ( ! function_exists( 'music_press_pro_get_all_albums_from_artist' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_all_albums_from_artist($artistID,$orderby,$order) {
        global $wpdb;
        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $album_values = "SELECT  DISTINCT * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID
        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
         WHERE pm.meta_key= 'album_artist'  AND po.post_status='publish' AND  pm.meta_value REGEXP '\"$artistID\"' ORDER BY ".$orderby." ".$order." ";
        $album_results = $wpdb->get_results($album_values );
        $album_arr = array();
        if($album_results){
            foreach ($album_results as $album){
                $ab = unserialize($album->meta_value);
                if($ab){
                    if($artistID==$ab || in_array($artistID, $ab)){
                        $album_arr[]=$album->post_id;
                    }
                }
            }
            return $album_arr;
        }
    }
}
if ( ! function_exists( 'music_press_pro_get_albums_from_band' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_albums_from_band($bandID,$limit,$orderby,$order) {
        global $wpdb;
        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $album_values = "SELECT  * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID
        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
        WHERE pm.meta_key= 'album_band'  AND po.post_status='publish' AND  pm.meta_value REGEXP '\"$bandID\"' ORDER BY ".$orderby." ".$order." LIMIT ".$limit."";
        $album_results = $wpdb->get_results($album_values );
        $album_arr = array();
        if($album_results){
            foreach ($album_results as $album){
                $ab = unserialize($album->meta_value);
                if($ab){
                    if($bandID==$ab || in_array($bandID, $ab)){
                        $album_arr[]=$album->post_id;
                    }
                }
            }
            return $album_arr;
        }
    }
}

if ( ! function_exists( 'music_press_pro_get_all_albums_from_band' ) ) {

    /**
     * Output songs ID From Genre
     *
     */
    function music_press_pro_get_all_albums_from_band($bandID,$orderby,$order) {
        global $wpdb;
        if($orderby=='mp_count_play'){
            $orderby='sop.plays';
        }else{
            $orderby='po.'.$orderby;
        }
        $album_values = "SELECT  * FROM " . $wpdb->prefix . "postmeta pm LEFT JOIN " . $wpdb->prefix . "posts po ON pm.post_id = po.ID
        LEFT JOIN(SELECT meta_key as song_plays, CONVERT(meta_value,UNSIGNED INTEGER) as plays, post_id FROM " . $wpdb->prefix . "postmeta
        WHERE meta_key ='mp_count_play') as sop ON sop.post_id=pm.post_id
        WHERE pm.meta_key= 'album_band'  AND po.post_status='publish' AND  pm.meta_value REGEXP '\"$bandID\"' ORDER BY ".$orderby." ".$order." ";
        $album_results = $wpdb->get_results($album_values );
        $album_arr = array();
        if($album_results){
            foreach ($album_results as $album){
                $ab = unserialize($album->meta_value);
                if($ab){
                    if($bandID==$ab || in_array($bandID, $ab)){
                        $album_arr[]=$album->post_id;
                    }
                }
            }
            return $album_arr;
        }
    }
}

if ( ! function_exists( 'music_press_pro_get_artists_from_band' ) ) {

    /**
     * Output artists ID From Band
     *
     */
    function music_press_pro_get_artists_from_band($bandID) {
        global $wpdb;
        $artist_values = "SELECT  * FROM " . $wpdb->prefix . "postmeta WHERE meta_key= 'artist_band' AND  meta_value REGEXP '".$bandID."'";
        $artist_results = $wpdb->get_results($artist_values );
        $artist_arr = array();
        if($artist_results){
            foreach ($artist_results as $artist){
                $ab = unserialize($artist->meta_value);
                if($ab){
                    if($bandID==$ab || in_array($bandID, $ab)){
                        $artist_arr[]=$artist->post_id;
                    }
                }
            }
            return $artist_arr;
        }
    }
}

if ( ! function_exists( 'music_press_pro_get_list_song_audio_by_ID' ) ) {

    /**
     * Get Song Type Audio From Array Song ID
     *
     */
    function music_press_pro_get_list_song_audio_by_ID($song_arr=array()) {
        echo '<ul class="all-songs">';
        foreach ($song_arr as $songID) {

            $file_type = get_field('song_type',$songID);
            $song_play = intval(music_press_pro_getPostViews($songID));
            if ($file_type == 'audio') {
                if (get_field('song_audio',$songID)) {
                    $file = get_field('song_audio',$songID);
                }
                if (get_field('song_audio_cover',$songID)) {
                    $file = get_field('song_audio_cover',$songID);
                }
                if ($file) {
                    ?>
                    <li><a href="<?php echo esc_url(get_permalink($songID)); ?>"><?php echo get_the_title($songID); ?></a>
                    <span class="song_plays"><i class="fa fa-headphones"></i> <?php echo esc_attr($song_play);?></span>
                    </li>
                    <?php
                }
            }
        }
        echo '</ul>';

        return;
    }
}

if ( ! function_exists( 'music_press_pro_get_list_song_video_by_ID' ) ) {

    /**
     * Get Song Type Video From Array Song ID
     *
     */
    function music_press_pro_get_list_song_video_by_ID($song_arr=array()) {
        echo '<div class="list-all">';
        foreach ($song_arr as $songID) {
            $song_type = get_field('song_type',$songID);
            if ($song_type == 'video') {
                if (get_field('song_video',$songID)) {
                    $song = get_field('song_video',$songID);
                }
                if (get_field('song_video_cover',$songID)) {
                    $song = get_field('song_video_cover',$songID);
                }

                if ($song) {
                    ?>
                    <div class="mp-item">
                        <a class="mp-img" href="<?php echo esc_url(get_permalink($songID)); ?>" style="background-image:url('<?php echo get_the_post_thumbnail_url($songID,'large'); ?>')">
                            <span><i class="fa fa-play"></i></span>
                        </a>
                        <h3><a href="<?php echo esc_url(get_permalink($songID)); ?>"><?php echo get_the_title($songID); ?></a></h3>

                        <?php
                        /*  Get Artists */
                        $artists = get_field('song_artist',$songID);
                        if($artists != null) {
                            echo '<div class="artist">';
                            $count = count($artists);
                            $i = 1;
                            $song_artist = '';
                            foreach ($artists as $artist) {
                                if ($i == $count) {
                                    $song_artist .= get_the_title($artist);
                                    echo '<a href="'.get_the_permalink($artist).'">'.get_the_title($artist).'</a>';
                                } else {
                                    $song_artist .= get_the_title($artist) . esc_html__(', ',  'music-press-pro');
                                    echo '<a href="'.get_the_permalink($artist).'">'.get_the_title($artist).'</a>'. esc_html__(', ',  'music-press-pro');
                                }
                                $i++;
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <?php
                }
            }
        }
        echo '</div>';

        return;
    }
}

if ( ! function_exists( 'music_press_pro_get_list_albums_by_ID' ) ) {

    /**
     * Get Lists Album From Array ID
     *
     */
    function music_press_pro_get_list_albums_by_ID($album_arr=array()) {
        echo '<div class="list-all">';
        foreach ($album_arr as $albumID) {
            ?>
            <div class="mp-item">
                <a class="mp-img" href="<?php echo esc_url(get_permalink($albumID)); ?>" style="background-image:url('<?php echo get_the_post_thumbnail_url($albumID,'large'); ?>')"></a>
                <h3><a href="<?php echo esc_url(get_permalink($albumID)); ?>"><?php echo get_the_title($albumID); ?></a></h3>
                <span><?php echo get_the_date('Y',$albumID); ?></span>
            </div>
            <?php
        }
        echo '</div>';

        return;
    }
}

if ( ! function_exists( 'music_press_pro_get_songs_wishlist' ) ) {

    /**
     * Get song wishlist
     *
     */
    function music_press_pro_get_songs_wishlist($songID) {
        $wishlist_class='';
        if(is_user_logged_in()){

            $logged_user_id = get_current_user_id();
            $wishlist_class='';

            global $wpdb;
            $table = $wpdb->prefix . "music_press_member_wishlist";
            $follow_result = $wpdb->get_results("SELECT * FROM $table WHERE song_id = '$songID' AND member_id = '$logged_user_id'", ARRAY_A);
            //var_dump($logged_user_id);

            $already_insert = $wpdb->num_rows;
            if($already_insert > 0 ){
                $wishlist_class = 'in_wishlist';

            }
            else{
                $wishlist_class = '';
            }
        }

        return $wishlist_class;
    }
}

if ( ! function_exists( 'music_press_pro_get_songs_playlist' ) ) {

    /**
     * Get song wishlist
     *
     */
    function music_press_pro_get_songs_playlist($songID,$playlist_id) {
        $wishlist_class='';
        if(is_user_logged_in()){

            $logged_user_id = get_current_user_id();
            $wishlist_class='';

            global $wpdb;
            $table = $wpdb->prefix . "music_press_member_song_relationships";
            $follow_result = $wpdb->get_results("SELECT * FROM $table WHERE song_id = $songID AND member_id = $logged_user_id AND playlist_id = $playlist_id", ARRAY_A);
            //var_dump($logged_user_id);

            $already_insert = $wpdb->num_rows;
            if($already_insert > 0 ){
                $wishlist_class = 'in_wishlist';

            }
            else{
                $wishlist_class = '';
            }
        }

        return $wishlist_class;
    }
}

if ( ! function_exists( 'music_press_pro_display_genre_song_audio' ) ) {

    /**
     * Output song Audio From Genre
     *
     */
    function music_press_pro_display_genre_song_audio() {
        mp_get_template( 'genre/genre-audio.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_genre_all_songs' ) ) {

    /**
     * Output song Audio From Genre
     *
     */
    function music_press_pro_display_genre_all_songs() {
        mp_get_template( 'genre/genre-all-songs.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_genre_song_video' ) ) {

    /**
     * Output song Video From Genre
     *
     */
    function music_press_pro_display_genre_song_video() {
        mp_get_template( 'genre/genre-video.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_genre_all_videos' ) ) {

    /**
     * Output song Video From Genre
     *
     */
    function music_press_pro_display_genre_all_videos() {
        mp_get_template( 'genre/genre-all-videos.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_genre_album' ) ) {

    /**
     * Output Album From Genre
     *
     */
    function music_press_pro_display_genre_album() {
        mp_get_template( 'genre/genre-album.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_genre_all_albums' ) ) {

    /**
     * Output Album From Genre
     *
     */
    function music_press_pro_display_genre_all_albums() {
        mp_get_template( 'genre/genre-all-albums.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_artist_song_audio' ) ) {

    /**
     * Output songs artist
     *
     */
    function music_press_pro_display_artist_song_audio() {
        mp_get_template( 'artist/artist-audio.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_artist_all_songs' ) ) {

    /**
     * Output songs artist
     *
     */
    function music_press_pro_display_artist_all_songs() {
        mp_get_template( 'artist/artist-all-songs.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_artist_all_videos' ) ) {

    /**
     * Output songs artist
     *
     */
    function music_press_pro_display_artist_all_videos() {
        mp_get_template( 'artist/artist-all-videos.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_artist_song_video' ) ) {

    /**
     * Output videos artist
     *
     */
    function music_press_pro_display_artist_song_video() {
        mp_get_template( 'artist/artist-video.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_artist_album' ) ) {

    /**
     * Output albums artist
     *
     */
    function music_press_pro_display_artist_album() {
        mp_get_template( 'artist/artist-album.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_artist_all_albums' ) ) {

    /**
     * Output albums artist
     *
     */
    function music_press_pro_display_artist_all_albums() {
        mp_get_template( 'artist/artist-all-albums.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_band_song_audio' ) ) {

    /**
     * Output songs artist
     *
     */
    function music_press_pro_display_band_song_audio() {
        mp_get_template( 'band/band-audio.php' );
    }
}

if ( ! function_exists( 'music_press_pro_display_band_all_songs' ) ) {

    /**
     * Output songs Band
     *
     */
    function music_press_pro_display_band_all_songs() {
        mp_get_template( 'band/band-all-songs.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_band_song_video' ) ) {

    /**
     * Output videos artist
     *
     */
    function music_press_pro_display_band_song_video() {
        mp_get_template( 'band/band-video.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_band_song_all_videos' ) ) {

    /**
     * Output videos Band
     *
     */
    function music_press_pro_display_band_song_all_videos() {
        mp_get_template( 'band/band-all-videos.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_band_song_all_members' ) ) {

    /**
     * Output videos Band
     *
     */
    function music_press_pro_display_band_song_all_members() {
        mp_get_template( 'band/band-all-members.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_band_album' ) ) {

    /**
     * Output albums Band
     *
     */
    function music_press_pro_display_band_album() {
        mp_get_template( 'band/band-album.php' );
    }
}
if ( ! function_exists( 'music_press_pro_display_band_all_albums' ) ) {

    /**
     * Output albums Band
     *
     */
    function music_press_pro_display_band_all_albums() {
        mp_get_template( 'band/band-all-albums.php' );
    }
}

if ( ! function_exists( 'music_press_pro_orderby_post_in' ) ) {

    /**
     * Order By Array ID
     *
     */
    function music_press_pro_orderby_post_in($post_in=array(),$post_type='mp_song',$orderby='date',$order='DESC') {
        $ID_arr = array();
        $args = array(
            'post_type'        => $post_type,
            'posts_per_page'   => 9999,
            'post__in'         => $post_in,
            'orderby'          => $orderby,
            'order'            => $order,
        );
        $mp_query = get_posts( $args );
        foreach ($mp_query as $mpID) {
            $ID_arr[] = $mpID->ID;
        }
        return $ID_arr;
    }
}

if ( ! function_exists( 'music_press_pro_getPostViews' ) ) {
    /**
     * Get View Post
     *
     * @return string
     */
    function music_press_pro_getPostViews( $ID ) {
        $count_key = 'mp_count_play';
        $count     = get_post_meta( $ID, $count_key, true );
        if ( $count == '' ) {
            delete_post_meta( $ID, $count_key );
            add_post_meta( $ID, $count_key, '0' );

            return '0';
        }
        return $count;
    }
}

if ( ! function_exists( 'music_press_pro_setPostViews' ) ) {
    /**
     * Set View Post
     *
     * @return string
     */
    function music_press_pro_setPostViews( $ID ) {
        $count_key = 'mp_count_play';
        $count     = (int) get_post_meta( $ID, $count_key, true );
        if ( $count < 1 ) {
            delete_post_meta( $ID, $count_key );
            add_post_meta( $ID, $count_key, '1' );
        } else {
            $count++;
            update_post_meta( $ID, $count_key, (string) $count );
        }
    }
}

if ( ! function_exists( 'music_press_pro_YouTubeGetID' ) ) {
    /**
     * Get YouTube ID from various YouTube URL
     *
     * @return string ID
     */
    function music_press_pro_YouTubeGetID( $url ) {
        $youtube_ID = '';
        $check_url = mb_strcut($url,0,7);
        if( $check_url == '<iframe' ){
            preg_match('/(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=‌​(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+/', $url, $matches);
            $youtube_ID = $matches[0];
        }elseif( $check_url == '<object' ){
            preg_match('#<object[^>]+>.+?http://www.youtube.com/v/([A-Za-z0-9\-_]+).+?#s', $url, $matches);
            $youtube_ID = $matches[1];
        }elseif( $check_url == 'http://' || $check_url = 'https:/' ){
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);
            $youtube_ID = $matches[1];
        }else{
            return $youtube_ID;
        }
        return $youtube_ID;
    }
}

if ( ! function_exists( 'music_press_pro_get_sidebar' ) ) {
    /**
     * Get Sidebar
     *
     * @return string ID
     */
    function music_press_pro_get_sidebar( ) {
        mp_get_template( 'global/sidebar.php' );
    }

}
<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
$songID = $post->ID;

/*  Get Song Audio Url or Embed */
$audio_embed = get_field('song_embed_audio',$songID);
if( isset($audio_embed) && !empty($audio_embed) ){
    if( wp_oembed_get( $audio_embed ) ) :
        echo wp_oembed_get( $audio_embed );
    else :
        echo ent2ncr( $audio_embed );
    endif;
}
?>
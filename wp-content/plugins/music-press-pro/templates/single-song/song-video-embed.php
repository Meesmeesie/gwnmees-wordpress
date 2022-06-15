<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
$songID = $post->ID;

/*  Get Song Video Url or Embed */
$video_embed = get_field('song_embed_video',$songID);
if( isset($video_embed) && !empty($video_embed) ){
    if( wp_oembed_get( $video_embed ) ) :
        echo wp_oembed_get( $video_embed );
    else :
        echo ent2ncr( $video_embed );
    endif;
}
?>
<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
$songID = $post->ID;
$artists = get_field('album_artist',$songID);
if($artists != null){
    ?>
    <span class="artist_label">
            <?php echo esc_html__('Artists:', 'music-press-pro'); ?>
    </span>
    <?php
    $count = count($artists);
    $i=1;
    foreach ($artists as $artist){
        if($i== $count){
            ?>
            <a href="<?php echo esc_url(get_permalink($artist));?>"><?php echo esc_attr(get_the_title($artist));?></a>
            <?php
        }else{
            ?>
            <a href="<?php echo esc_url(get_permalink($artist));?>"><?php echo esc_attr(get_the_title($artist));?></a><?php echo esc_html__(',', 'music-press-pro');
        }
        $i++;
    }
}
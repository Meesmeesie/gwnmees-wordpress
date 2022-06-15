<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
$songID = $post->ID;
$albums = get_field('song_album',$songID);
if($albums != null){
    ?>
    <span class="album_label">
        <?php esc_html_e('Albums:&nbsp;&nbsp;', 'music-press-pro'); ?>
    </span>
    <?php
    $count = count($albums);
    $i=1;
    foreach ($albums as $album){
        if($i== $count){
            ?>
            <a href="<?php echo esc_url(get_permalink($album));?>"><?php echo esc_attr(get_the_title($album));?></a>
            <?php
        }else{
            ?>
            <a href="<?php echo esc_url(get_permalink($album));?>"><?php echo esc_attr(get_the_title($album));?></a><?php echo esc_html__(',', 'music-press-pro');
        }
        $i++;
    }
}

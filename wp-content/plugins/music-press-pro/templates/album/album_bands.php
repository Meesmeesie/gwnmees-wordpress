<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
$songID = $post->ID;
$bands = get_field('album_band',$songID);
if($bands != null){
    ?>
    <span class="band_label">
        <?php echo esc_html__('Bands:', 'music-press-pro'); ?>
    </span>
    <?php
    $count = count($bands);
    $i=1;
    foreach ($bands as $band){
        if($i== $count){
        ?>
            <a href="<?php echo esc_url(get_permalink($band));?>"><?php echo esc_attr(get_the_title($band));?></a>
        <?php
        }else{
        ?>
            <a href="<?php echo esc_url(get_permalink($band));?>"><?php echo esc_attr(get_the_title($band));?></a><?php echo esc_html__(',', 'music-press-pro');
        }
        $i++;
    }
}
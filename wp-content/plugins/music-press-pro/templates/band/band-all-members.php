<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$bandID = get_the_ID();
$artist_arr = music_press_pro_get_artists_from_band($bandID);
if($artist_arr){
?>
<div class="mp-list artists">
    <?php
        foreach ($artist_arr as $artist_id){
            ?>
            <div class="member-item">
                <a class="member-img" href="<?php echo esc_url(get_permalink($artist_id)); ?>">
                    <img src="<?php echo get_the_post_thumbnail_url($artist_id,'large'); ?>"></a>
                <h3>
                    <a href="<?php echo esc_url(get_permalink($artist_id)); ?>"><?php echo get_the_title($artist_id); ?></a>
                </h3>
                <div class="member-desc"><?php echo esc_html(get_field('artist_short_desc',$artist_id)); ?></div>
                <div class="clr"></div>
            </div>
            <?php
        }
        ?>
</div>
<?php
}
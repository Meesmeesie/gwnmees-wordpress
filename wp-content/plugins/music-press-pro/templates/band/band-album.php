<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$bandID = get_the_ID();
$limit = get_option('options_global_limit',8);
$orderby = get_option('options_global_orderby','mp_count_play');
$order = get_option('options_global_order','DESC');
$album_arr = music_press_pro_get_albums_from_band($bandID,$limit,$orderby,$order);
if($album_arr){
?>
<div class="mp-list albums">
    <h2 class="mp-title mp-line"><?php echo esc_attr__('Albums', 'music-press-pro');?></h2>
    <?php
        music_press_pro_get_list_albums_by_ID($album_arr);
        ?>
</div>
<?php
}
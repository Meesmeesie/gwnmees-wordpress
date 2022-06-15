<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$bandID = get_the_ID();
$limit = get_option('options_band_all_album_limit',8);
$orderby = get_option('options_global_orderby','mp_count_play');
$order = get_option('options_global_order','DESC');
$album_arr = music_press_pro_get_all_albums_from_band($bandID,$orderby,$order);
if($album_arr){
?>
<div class="mp-list albums">
    <h2 class="mp-title mp-line"><?php echo esc_attr__('Albums', 'music-press-pro');?></h2>
    <?php
        $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
        $args = array(
            'post_type'        => 'mp_album',
            'posts_per_page' => $limit,
            'paged'          => $paged,
            'post__in'         => $album_arr,
        );
        $the_query = new WP_Query( $args );
        if( $the_query->have_posts() ):
            echo '<div class="list-all">';
            while( $the_query->have_posts() ): $the_query->the_post();

                ?>
                <div class="mp-item">
                    <a class="mp-img" href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" style="background-image:url('<?php echo get_the_post_thumbnail_url(get_the_ID(),'large'); ?>')"></a>
                    <h3><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo get_the_title(get_the_ID()); ?></a></h3>
                    <span><?php echo get_the_date('Y',get_the_ID()); ?></span>
                </div>
                <?php

            endwhile;

            echo paginate_links( array(
                'base' => @add_query_arg('page','%#%'),
                'current' => $paged,
                'total' => $the_query->max_num_pages,
                'format' => '?page=%#%'
            ) );
            wp_reset_postdata();
            echo '</div>';
        endif;
        ?>
</div>
<?php
}
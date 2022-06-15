<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$bandID = get_the_ID();
$type='audio';
$limit =get_option('options_band_all_song_limit',8);
$orderby = get_option('options_global_orderby','mp_count_play');
$order = get_option('options_global_order','DESC');
$song_arr = music_press_pro_get_all_songs_from_band($bandID,$orderby,$order,$type);
if($song_arr){
?>
<div class="mp-list audio">
    <h2 class="mp-title mp-line"><?php echo esc_attr__('Songs', 'music-press-pro');?></h2>
    <?php
        $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
        $args = array(
            'post_type'        => 'mp_song',
            'posts_per_page' =>$limit,
            'paged'          => $paged,
            'post__in'       => $song_arr,
            'orderby'        => 'mp_count_play',
            'meta_key'       =>'mp_count_play',
            'order'          => $order
        );
        $the_query = new WP_Query( $args );
        if( $the_query->have_posts() ):
            echo '<ul class="all-songs">';
            while( $the_query->have_posts() ): $the_query->the_post();
                $song_play = intval(music_press_pro_getPostViews(get_the_ID()));
                ?>
                <li><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo get_the_title(get_the_ID()); ?></a>
                    <span class="song_plays"><i class="fa fa-headphones"></i> <?php echo esc_attr($song_play);?></span>
                </li>
                <?php

            endwhile;

            echo paginate_links( array(
                'base' => @add_query_arg('page','%#%'),
                'current' => $paged,
                'total' => $the_query->max_num_pages,
                'format' => '?page=%#%'
            ) );
            wp_reset_postdata();
            echo '</ul>';
        endif;
        ?>
</div>
<?php
}
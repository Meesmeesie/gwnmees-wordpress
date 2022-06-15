<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$artistID = get_the_ID();
$type='video';
$limit = get_option('options_artist_all_video_limit',8);
$orderby = get_option('options_global_orderby','mp_count_play');
$order = get_option('options_global_order','DESC');
$song_arr = music_press_pro_get_all_songs_from_artist($artistID,$orderby,$order,$type);
if($song_arr ) { ?>
    <div class="mp-list audio">
        <h2 class="mp-title mp-line"><?php echo esc_attr__('Videos', 'music-press-pro'); ?></h2>
        <?php
        if ($song_arr) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
            $args = array(
                'post_type' => 'mp_song',
                'posts_per_page' => $limit,
                'paged' => $paged,
                'post__in' => $song_arr,
            );
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()):
                echo '<div class="list-all">';
                while ($the_query->have_posts()): $the_query->the_post();

                    ?>
                    <div class="mp-item">
                        <a class="mp-img" href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"
                           style="background-image:url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>')">
                            <span><i class="fa fa-play"></i></span>
                        </a>
                        <h3>
                            <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo get_the_title(get_the_ID()); ?></a>
                        </h3>

                        <?php
                        /*  Get Artists */
                        $artists = get_field('song_artist', get_the_ID());
                        if ($artists != null) {
                            echo '<div class="artist">';
                            $count = count($artists);
                            $i = 1;
                            $song_artist = '';
                            foreach ($artists as $artist) {
                                if ($i == $count) {
                                    $song_artist .= get_the_title($artist);
                                    echo '<a href="' . get_the_permalink($artist) . '">' . get_the_title($artist) . '</a>';
                                } else {
                                    $song_artist .= get_the_title($artist) . esc_html__(', ', 'music-press-pro');
                                    echo '<a href="' . get_the_permalink($artist) . '">' . get_the_title($artist) . '</a>' . esc_html__(', ', 'music-press-pro');
                                }
                                $i++;
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <?php

                endwhile;

                echo paginate_links(array(
                    'base' => @add_query_arg('page', '%#%'),
                    'current' => $paged,
                    'total' => $the_query->max_num_pages,
                    'format' => '?page=%#%'
                ));
                wp_reset_postdata();
                echo '</div>';
            endif;
        }
        ?>
    </div>
    <?php
}
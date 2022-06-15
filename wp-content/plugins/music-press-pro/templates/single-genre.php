<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();
if(isset($_GET['view'])){
    $page_view = $_GET['view'];
}else{
    $page_view ='';
}
$all_class = $song_class = $album_class = $video_class = $des_class ='';
if($page_view=='' ){
    $all_class='active';
}elseif($page_view=='songs' ){
    $song_class='active';
}elseif($page_view=='videos' ){
    $video_class='active';
}elseif($page_view=='albums' ){
    $album_class='active';
}elseif($page_view=='description' ){
    $des_class='active';
}
    $genre_banner = get_field('genre_banner');
    $genre_banner_url = wp_get_attachment_url( $genre_banner );

    $genreID = get_the_ID();
    ?>
    <div class="mp mp-genre mp-white wrap">
        <div class="genre-info" style="background-image: url('<?php echo esc_url($genre_banner_url);?>')">
            <div class="info-container">
                <?php if ( has_post_thumbnail() ){ ?>
                    <div class="mp-avatar">
                        <?php the_post_thumbnail();?>
                    </div>
                <?php }?>
                <div class="mp-excerpt">
                    <h4 class="name"><?php the_title();?></h4>
                    <div class="description"><?php echo esc_html(get_field('genre_short_desc',$genreID));?></div>
                </div>
            </div>
        </div>

        <div class="genre-links">
            <a href="<?php the_permalink($genreID);?>" class="<?php echo esc_attr($all_class);?>"><?php echo esc_attr__('All', 'music-press-pro');?></a>
            <a href="<?php the_permalink($genreID);?>?view=songs" class="<?php echo esc_attr($song_class);?>"><?php echo esc_attr__('Songs', 'music-press-pro');?></a>
            <a href="<?php the_permalink($genreID);?>?view=albums" class="<?php echo esc_attr($album_class);?>"><?php echo esc_attr__('Albums', 'music-press-pro');?></a>
            <a href="<?php the_permalink($genreID);?>?view=videos" class="<?php echo esc_attr($video_class);?>"><?php echo esc_attr__('Videos', 'music-press-pro');?></a>
            <a href="<?php the_permalink($genreID);?>?view=description" class="<?php echo esc_attr($des_class);?>"><?php echo esc_attr__('Description', 'music-press-pro');?></a>
        </div>
        <?php
        switch($page_view){
            case 'songs':
                do_action('music_press_pro_genre_list_all_songs');
                break;
            case 'albums':
                do_action('music_press_pro_genre_list_all_albums');
                break;
            case 'videos':
                do_action('music_press_pro_genre_list_all_videos');
                break;
            case 'description':
                ?>
                <div class="description"><?php the_content();?></div>
                <?php
                break;
            default:
                do_action('music_press_pro_genre_list_audio');
                do_action('music_press_pro_genre_list_album');
                do_action('music_press_pro_genre_list_video');
        }
        ?>
    </div>
    <?php
do_action( 'music_press_pro_sidebar' );
get_footer();
?>
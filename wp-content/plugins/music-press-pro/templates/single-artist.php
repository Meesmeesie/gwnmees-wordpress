<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();
wp_enqueue_script('music-press-js');
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
//while ( have_posts() ) : the_post();
    $artist_banner = get_field('artist_banner');
    $artist_banner_url = wp_get_attachment_url( $artist_banner );

    $artistID = get_the_ID();
    $artist_comment = get_option('options_artist_comment','yes');
if (class_exists('MusicPressMember')){
    $is_following = '';
    $follow_text = __('Follow', 'music-press-member');
    $follow_class = '';


    if (is_user_logged_in()) {

        $logged_user_id = get_current_user_id();


        global $wpdb;
        $table = $wpdb->prefix . "music_press_member_follow";
        $follow_result = $wpdb->get_results("SELECT * FROM $table WHERE artist_id = '$artistID' AND follower_id = '$logged_user_id'", ARRAY_A);
        //var_dump($logged_user_id);

        $already_insert = $wpdb->num_rows;
        if ($already_insert > 0) {

            $is_following = 'yes';
            $follow_text = __('Following', 'music-press-member');
            $follow_class = 'following';

        } else {
            $is_following = 'yes';
            $follow_text = __('Follow', 'music-press-member');
            $follow_class = '';
        }
    }
}
?>
<div class="mp mp-artist mp-white wrap">
    <div class="artist-info" style="background-image: url('<?php echo esc_url($artist_banner_url);?>')">
        <div class="info-container">
            <?php if ( has_post_thumbnail() ){ ?>
                <div class="mp-avatar">
                    <?php the_post_thumbnail();?>
                </div>
            <?php }?>
            <div class="mp-excerpt">
                <h4 class="name reset-heading"><?php the_title();?></h4>
                <div class="description"><?php echo esc_html(get_field('artist_short_desc',$artistID));?></div>
            </div>
            <?php
            if (class_exists('MusicPressMember')){
            ?><div class="mpresults" style="display: none"></div>
            <div class="mp_follow <?php echo $follow_class; ?>" artist_id="<?php echo $artistID;?>">
                <i class="fa fa-user-plus" aria-hidden="true"></i><?php echo $follow_text;?>
            </div>
            <?php } ?>
        </div>
    </div>

    <div class="artist-links">
        <a href="<?php the_permalink($artistID);?>" class="<?php echo esc_attr($all_class);?>"><?php echo esc_attr__('All', 'music-press-pro');?></a>
        <a href="<?php the_permalink($artistID);?>?view=songs" class="<?php echo esc_attr($song_class);?>"><?php echo esc_attr__('Songs', 'music-press-pro');?></a>
        <a href="<?php the_permalink($artistID);?>?view=albums" class="<?php echo esc_attr($album_class);?>"><?php echo esc_attr__('Albums', 'music-press-pro');?></a>
        <a href="<?php the_permalink($artistID);?>?view=videos" class="<?php echo esc_attr($video_class);?>"><?php echo esc_attr__('Videos', 'music-press-pro');?></a>
        <a href="<?php the_permalink($artistID);?>?view=description" class="<?php echo esc_attr($des_class);?>"><?php echo esc_attr__('Description', 'music-press-pro');?></a>
    </div>

    <?php
    switch($page_view){
        case 'songs':
            do_action('music_press_pro_artist_list_all_songs');
        break;
        case 'albums':
            do_action('music_press_pro_artist_list_all_albums');
        break;
        case 'videos':
            do_action('music_press_pro_artist_list_all_videos');
        break;
        case 'description':
            ?>
            <div class="description"><?php echo do_shortcode( '[music_press_pro_description]' );?></div>
            <?php
        break;
        default:
            do_action('music_press_pro_artist_list_audio');
            do_action('music_press_pro_artist_list_album');
            do_action('music_press_pro_artist_list_video');
    }
    ?>
    <?php
//endwhile;
    ?>
</div>

<?php
if($artist_comment=='yes'){
    ?>
    <div class="mp mp-comments wrap">
        <?php comments_template('',true); ?>
    </div>
    <?php
}
do_action( 'music_press_pro_sidebar' );
get_footer();
?>
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();
if(isset($_GET['view'])){
    $page_view = $_GET['view'];
}else{
    $page_view ='';
}
$all_class = $song_class = $album_class = $video_class = $des_class =$member_class='';
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
}elseif($page_view=='members' ){
    $member_class='active';
}
$band_comment = get_option('options_band_comment','yes');
while ( have_posts() ) : the_post();
    $band_banner = get_field('band_banner');
    $aband_banner_url = wp_get_attachment_url( $band_banner );

    $bandID = get_the_ID();
?>
<div class="mp mp-band mp-white wrap">
    <div class="band-info" style="background-image: url('<?php echo esc_url($aband_banner_url);?>')">
        <div class="info-container">
            <?php if ( has_post_thumbnail() ){ ?>
                <div class="mp-avatar">
                    <?php the_post_thumbnail();?>
                </div>
            <?php }?>
            <div class="mp-excerpt">
                <h4 class="name"><?php the_title();?></h4>
                <div class="description"><?php echo esc_html(get_field('band_short_desc',$bandID));?></div>
            </div>
        </div>
    </div>

    <div class="artist-links">
        <a href="<?php the_permalink($bandID);?>" class="<?php echo esc_attr($all_class);?>"><?php echo esc_attr__('All', 'music-press-pro');?></a>
        <a href="<?php the_permalink($bandID);?>?view=songs" class="<?php echo esc_attr($song_class);?>"><?php echo esc_attr__('Songs', 'music-press-pro');?></a>
        <a href="<?php the_permalink($bandID);?>?view=albums" class="<?php echo esc_attr($album_class);?>"><?php echo esc_attr__('Albums', 'music-press-pro');?></a>
        <a href="<?php the_permalink($bandID);?>?view=videos" class="<?php echo esc_attr($video_class);?>"><?php echo esc_attr__('Videos', 'music-press-pro');?></a>
        <a href="<?php the_permalink($bandID);?>?view=members" class="<?php echo esc_attr($member_class);?>"><?php echo esc_attr__('Members', 'music-press-pro');?></a>
        <a href="<?php the_permalink($bandID);?>?view=description" class="<?php echo esc_attr($des_class);?>"><?php echo esc_attr__('Description', 'music-press-pro');?></a>
    </div>
    <?php
    switch($page_view){
        case 'songs':
            do_action('music_press_pro_band_list_all_songs');
            break;
        case 'albums':
            do_action('music_press_pro_band_list_all_albums');
            break;
        case 'videos':
            do_action('music_press_pro_band_list_all_videos');
            break;
        case 'members':
            do_action('music_press_pro_band_list_all_members');
            break;
        case 'description':
            ?>
            <div class="description"><?php the_content();?></div>
            <?php
            break;
        default:
            do_action('music_press_pro_band_list_audio');
            do_action('music_press_pro_band_list_album');
            do_action('music_press_pro_band_list_video');
    }
    ?>
</div>
<?php
endwhile;
if($band_comment=='yes'){
    ?>
    <div class="mp mp-comments wrap">
        <?php comments_template('',true); ?>
    </div>
    <?php
}
do_action( 'music_press_pro_sidebar' );
get_footer();
?>
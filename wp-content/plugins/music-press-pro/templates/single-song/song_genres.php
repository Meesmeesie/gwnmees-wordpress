<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
$songID = $post->ID;
$genres = get_field('song_genre',$songID);
if($genres != null){
    ?>
    <span class="genre_label">
        <?php echo esc_html__('Genres:', 'music-press-pro'); ?>
    </span>
    <?php
    $count = count($genres);
    $i=1;
    foreach ($genres as $genre){
        if($i== $count){
            ?>
            <a href="<?php echo esc_url(get_permalink($genre));?>"><?php echo esc_attr(get_the_title($genre));?></a>
            <?php
        }else{
            ?>
            <a href="<?php echo esc_url(get_permalink($genre));?>"><?php echo esc_attr(get_the_title($genre));?></a><?php echo esc_html__(',', 'music-press-pro');
        }
        $i++;
    }
}
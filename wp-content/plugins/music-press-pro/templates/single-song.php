<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header();
$album_player =get_option('options_global_music_player','jplayer');
while ( have_posts() ) : the_post();
    $file_type      = get_field('song_type',get_the_ID());
    $song_source    = get_field('song_source',get_the_ID());
	$songID = get_the_ID();
    /*  Set View Song   */
    music_press_pro_setPostViews($songID);

    if( !$song_source){
        $song_source = 'upload';
    }
?>
<div class="mp mp-single song mp-white wrap">
   
<?php
    if($album_player=='wavesurfer'){
        do_action('music_press_pro_song_wave_player');
    }else{
        if($file_type=='audio') {
            if( $song_source == 'upload' ){
                /*  Song Audio Playder    */
                do_action('music_press_pro_song_player');
            }elseif( $song_source == 'embed' ){
                /*  Song Audio Embed    */
                do_action('music_press_pro_song_embed');
            }
        }else{

            if( $song_source == 'upload' ){
                /*  Song Audio Playder    */
                do_action('music_press_pro_song_video_player');
            }elseif( $song_source == 'embed' ){
                /*  Song Audio Embed    */
                do_action('music_press_pro_song_video_embed');

            }
        }
    }

?>
    <div class="mp-info">
        <div class="mp-genres">
            <?php
            do_action('music_press_pro_song_genre');
            ?>
        </div>
        <div class="mp-albums">
            <?php
            do_action('music_press_pro_song_album');
            ?>
        </div>
        <div class="mp-band">
            <?php
            do_action('music_press_pro_song_band');
            ?>
        </div>
        <div class="mp-artist">
            <?php
            do_action('music_press_pro_song_artist');
            ?>
        </div>
    </div>

    <div class="mp-description">
        <?php the_content();?>
    </div>

		<?php
		if(get_field('song_for_sale')){?>
			<a class="sale_song" href="<?php echo esc_url(get_field('song_for_sale'));?>" target="_blank">
				<?php echo esc_html__('Buy Now', 'music-press-pro'); ?>
			</a>
			<?php
		}
		?>
		<?php if(get_field('song_lyric')){ ?>
        <div class="mp-lyric">
            <h3><?php echo esc_html__('Lyric', 'music-press-pro');?></h3>
			<div class="song-lyric">
				<?php echo balanceTags(get_field('song_lyric'));?>
			</div>
        </div>
		<?php } ?>

    <div class="mp-comments">
        <?php comments_template('',true); ?>
    </div>
</div>
<?php
endwhile;
do_action( 'music_press_pro_sidebar' );
get_footer();
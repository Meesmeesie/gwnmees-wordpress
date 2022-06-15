<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$album_lyric =get_option('options_album_lyric','yes');

$autoplay =get_option('options_album_autoplay','yes');
$image_player =get_option('options_album_image_player','image_album');
$orderby =get_option('options_album_orderby','post_date');
$order =get_option('options_album_order','DESC');
$download =get_option('options_global_download','true');
$ajax_player = true;
global $post, $wpdb;
$albumID = $post->ID;
$album_imageID = get_field( 'album_poster',$albumID);
if(isset($album_imageID)){
    $album_image =  wp_get_attachment_url( $album_imageID );
}else{
    $album_image='';
}

$song_arr = music_press_pro_get_songs_from_album($albumID,$orderby,$order);
/*  Check Song Source   */
$has_embed = $has_upload = false;
if($song_arr){
    foreach ($song_arr as $song_ID){
        $file_source = get_field('song_source',$song_ID);
        if( $file_source == 'upload' ){
            $has_upload = true;
        }
        if( $file_source == 'embed' ){
            $has_embed = true;
        }
    }
}
if($has_upload){

    wp_enqueue_script('music-press-wave-js');
    ?>

    <div class="mp_wave_playlist">
        <div id="album_wave_playlist">
            <div class="row">
                <div class="col-sm-10">
                    <div id="waveform">
                        <!-- Here be waveform -->
                    </div>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-block" id="playPause">
                        <span id="play"><?php esc_html_e('Play','disme'); ?></span>
                        <span id="pause" style="display: none"><?php esc_html_e('Pause','disme'); ?></span>
                    </button>
                </div>
            </div>

            <div class="list-group" id="playlist">

                <?php if ( $song_arr ) :
                    $mp_count = 1;
                    foreach ($song_arr as $song){
                        $file_type = get_field('song_type',$song);
                        if($file_type=='audio'){
                            $mp_count_item = $mp_count;
                            if( $mp_count < 10 ){
                                $mp_count_item = '0'.$mp_count;
                            }
                            /*  Get Song Field */
                            if(get_field('song_audio',$song)){
                                $file = get_field('song_audio',$song);
                            }
                            if(get_field('song_audio_cover',$song)){
                                $file = get_field('song_audio_cover',$song);
                            }
                            /*  Get Artists */
                            $artists = get_field('song_artist',$song);
                            if($artists != null) {
                                $count = count($artists);
                                $i = 1;
                                $song_artist = '';
                                foreach ($artists as $artist) {
                                    if ($i == $count) {
                                        $song_artist .= get_the_title($artist);
                                    } else {
                                        $song_artist .= get_the_title($artist) . esc_html__(', ',  'music-press-pro');
                                    }
                                    $i++;
                                }
                            }else{
                                $song_artist = '';
                            }
                            if(isset($file)){
                                $url = wp_get_attachment_url( $file );
                            }else{
                                $url = get_field('song_audio_link',$song);
                            }
                            require_once( ABSPATH . 'wp-content/plugins/music-press-pro/includes/duration.php' );
                            $time_mp3 = new TZ_Music_Mp3Data( $url );
                            ?>
                            <a href="<?php echo esc_url($url);?>" class="song-item">
                                <span class="count"><?php echo esc_html($mp_count_item); ?></span>
                                <!--                            <i class="glyphicon glyphicon-play"></i>-->
                                <h5><?php echo get_the_title($song);?><span class="artist"><?php echo ' - '.esc_attr($song_artist);?></span></h5>
                                <span class="badge"><?php echo $time_mp3->music_press_pro_get_mp3_duration();?></span>

                            </a>
                            <?php
                            if($album_lyric=='yes') {
                                ?>
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#myModal<?php echo $song; ?>">
                                    Lyric
                                </button>

                                <!-- The Modal -->
                                <div class="modal" id="myModal<?php echo $song; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?php echo get_the_title($song); ?></h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <?php
                                                echo balanceTags(get_field('song_lyric', $song));
                                                ?>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <span class="badge download_song" data-href="<?php echo esc_url(get_permalink($file)).'?song_id='.$file.'&download=1';?> "><i class="fa fa-download"></i> </span>
                <?php

                            $mp_count++;
                        }
                    } endif;?>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        // Create a WaveSurfer instance
        var wavesurfer;

        // Init on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            wavesurfer = WaveSurfer.create({
                container: '#waveform',
                waveColor: '#7d7d7d',
                progressColor: '#000000',
                height: 130,
                barWidth: 0.01,
                forceDecode: false,/*Force decoding of audio using web audio when zooming to get a more detailed waveform.*/
                hideScrollbar: false,/*Whether to hide the horizontal scrollbar when one would normally be shown.*/
                mediaControls: true,/*(Use with backend MediaElement) this enables the native controls for the media element.*/

            });
        });

        // Bind controls
        document.addEventListener('DOMContentLoaded', function() {
            var playPause = document.querySelector('#playPause');
            playPause.addEventListener('click', function() {
                wavesurfer.playPause();
            });

            // Toggle play/pause text
            wavesurfer.on('play', function() {
                document.querySelector('#play').style.display = 'none';
                document.querySelector('#pause').style.display = '';
            });
            wavesurfer.on('pause', function() {
                document.querySelector('#play').style.display = '';
                document.querySelector('#pause').style.display = 'none';
            });

            // The playlist links
            var links = document.querySelectorAll('#playlist a');
            var currentTrack = 0;

            // Load a track by index and highlight the corresponding link
            var setCurrentSong = function(index) {
                links[currentTrack].classList.remove('active');
                currentTrack = index;
                links[currentTrack].classList.add('active');
                wavesurfer.load(links[currentTrack].href);
            };

            // Load the track on click
            Array.prototype.forEach.call(links, function(link, index) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    setCurrentSong(index);
                });
            });

            // Play on audio load
            wavesurfer.on('ready', function() {
                wavesurfer.play();
            });

            // Go to the next track on finish
            wavesurfer.on('finish', function() {
                setCurrentSong((currentTrack + 1) % links.length);
            });

            // Load the first track
            setCurrentSong(currentTrack);
        });

        jQuery('.download_song').on('click',function(){
            url = jQuery(this).attr('data-href');
            window.location.href = ''+url+'';
        })

    </script>
    <?php
}
if( $has_embed ){
    do_action('music_press_pro_album_embed');
}
?>
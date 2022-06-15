<?php
if (!defined('ABSPATH')) {
    exit;
}
wp_enqueue_script('music-press-wave-js');
global $post;
$songID = $post->ID;
$autoplay = 'yes';


if (get_field('song_audio')) {
    $file = get_field('song_audio');
}
if (get_field('song_audio_cover')) {
    $file = get_field('song_audio_cover');
}
if ($file) {
    $url = wp_get_attachment_url($file);
} else {
    $url = get_field('song_audio_link');
}
?>
<div id="waveform"></div>
<script type="text/javascript">
    var wavesurfer;

    // Init on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        wavesurfer = WaveSurfer.create({
            container: '#waveform',
            waveColor: '#428bca',
            progressColor: '#31708f',
            height: 120,
            barWidth: 3
        });
        wavesurfer.load('<?php echo $url;?>');
        wavesurfer.on('ready', function () {
            wavesurfer.play();
        });
    });

</script>
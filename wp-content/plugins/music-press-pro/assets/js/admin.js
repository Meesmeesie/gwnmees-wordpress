/**
 * Created by Administrator on 5/18/2016.
 */

jQuery(document).ready(function(){
    var start_checked =  jQuery( ".song_type input:checked" ).val();
    var license_checked =  jQuery( ".song_license input:checked" ).val();
    var source_checked =  jQuery( ".song_source input:checked" ).val();
    if(start_checked =='video' && license_checked=='free'){
        if( source_checked == 'upload' ){
            jQuery('#acf-song_video').addClass('tzshow');
            jQuery('#acf-song_video_link').addClass('tzshow');
        }else{
            jQuery('#acf-song_embed_video').addClass('tzshow');
        }
    }
    if(start_checked =='video' && license_checked=='sale'){
        jQuery('#acf-song_video_cover').addClass('tzshow');
    }
    if(start_checked =='audio' && license_checked=='free'){
        if( source_checked == 'upload' ){
            jQuery('#acf-song_audio').addClass('tzshow');
            jQuery('#acf-song_audio_link').addClass('tzshow');
        }else{
            jQuery('#acf-song_embed_audio').addClass('tzshow');
        }
    }
    if(start_checked =='audio' && license_checked=='sale'){
        jQuery('#acf-song_audio_cover').addClass('tzshow');
    }

    jQuery( ".acf-radio-list input" ).on( "click", function() {
        var license_checked =  jQuery( ".song_license input:checked" ).val();
        var type_checked = jQuery( ".song_type input:checked" ).val();
        var source_checked =  jQuery( ".song_source input:checked" ).val();
        if(license_checked =='sale' && type_checked =='audio'){
            jQuery('#acf-song_price ').addClass('tzshow');
            jQuery('#acf-song_audio_cover').addClass('tzshow');
            jQuery('#acf-song_audio').removeClass('tzshow');
            jQuery('#acf-song_video').removeClass('tzshow');
            jQuery('#acf-song_video_cover').removeClass('tzshow');
            jQuery('#acf-song_video_link').removeClass('tzshow');
        }
        if(license_checked =='sale' && type_checked =='video'){
            jQuery('#acf-song_price ').addClass('tzshow');
            jQuery('#acf-song_video_cover').addClass('tzshow');
            jQuery('#acf-song_video').removeClass('tzshow');
            jQuery('#acf-song_audio').removeClass('tzshow');
            jQuery('#acf-song_audio_cover').removeClass('tzshow');
            jQuery('#acf-song_video_link').removeClass('tzshow');
        }
        if(license_checked =='free' && type_checked =='audio'){
            jQuery('#acf-song_price ').removeClass('tzshow');
            jQuery('#acf-song_audio_cover').removeClass('tzshow');
            jQuery('#acf-song_video').removeClass('tzshow');
            jQuery('#acf-song_video_cover').removeClass('tzshow');
            jQuery('#acf-song_embed_video').removeClass('tzshow');
            jQuery('#acf-song_video_link').removeClass('tzshow');
            if( source_checked == 'upload' ){
                jQuery('#acf-song_embed_audio').removeClass('tzshow');
                jQuery('#acf-song_audio').addClass('tzshow');
                jQuery('#acf-song_audio_link').addClass('tzshow');
            }else{
                jQuery('#acf-song_audio').removeClass('tzshow');
                jQuery('#acf-song_audio_link').removeClass('tzshow');
                jQuery('#acf-song_embed_audio').addClass('tzshow');
            }
        }
        if(license_checked =='free' && type_checked =='video'){
            jQuery('#acf-song_price ').removeClass('tzshow');
            jQuery('#acf-song_video_cover').removeClass('tzshow');
            jQuery('#acf-song_audio').removeClass('tzshow');
            jQuery('#acf-song_audio_cover').removeClass('tzshow');
            jQuery('#acf-song_embed_audio').removeClass('tzshow');
            jQuery('#acf-song_audio_link').removeClass('tzshow');
            if( source_checked == 'upload' ){
                jQuery('#acf-song_video').addClass('tzshow');
                jQuery('#acf-song_embed_video').removeClass('tzshow');
                jQuery('#acf-song_video_link').addClass('tzshow');
            }else{
                jQuery('#acf-song_video').removeClass('tzshow');
                jQuery('#acf-song_embed_video').addClass('tzshow');
                jQuery('#acf-song_video_link').removeClass('tzshow');
            }
        }

    })
});
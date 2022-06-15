
(function() {
    tinymce.PluginManager.add('music_press_pro_shortcode_btn', function( editor, url ) {
        editor.addButton( 'music_press_pro_shortcode_btn', {
            text: 'Music Press Pro',
            type: 'menubutton',
            icon: 'icon',
            image: url + '/icon.png',
            menu: [
                {
                    text: 'Add Album',
                    value: 'Add Album',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Insert Album',
                            width:450,
                            height:350,
                            html :
                            '<div id="albums-select" class="album-popup" tabindex="-1">' +
                            jQuery('.album_select').html()+
                            '</div>',

                            buttons: [
                                {
                                    text: 'Cancel',
                                    onclick: 'close'
                                },
                                {
                                    text: 'Save Album',
                                    onclick: function(){
                                        //some code here that modifies the selected node in TinyMCE
                                        tinyMCE.activeEditor.insertContent('[music_press_pro_album album_id="'+ jQuery('#albums-select .albums').val()+'" ' +
                                            ' autoplay="'+ jQuery('#albums-select .album_autoplay').val()+'"' +
                                            ' volume="'+ jQuery('#albums-select .volume').val()+'" ' +
                                            ' repeat="'+ jQuery('#albums-select .repeat').val()+'" ' +
                                            ' poster="'+ jQuery('#albums-select .poster').val()+'"' +
                                            ' song_orderby="'+ jQuery('#albums-select .song_orderby').val()+'"'+
                                            ' song_order="'+ jQuery('#albums-select .song_order').val()+'"]'
                                        );
                                        tinymce.activeEditor.windowManager.close();
                                    }
                                }
                            ]
                        });
                    }
                },
                {
                    text: 'Add Artist',
                    value: 'Add Artist',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Choose Artist',
                            width:450,
                            height:300,
                            html :
                            '<div id="artist-select" class="album-popup" tabindex="-1">' +
                            jQuery('.artist_select').html()+
                            '</div>',

                            buttons: [
                                {
                                    text: 'Cancel',
                                    onclick: 'close'
                                },
                                {
                                    text: 'Save',
                                    onclick: function(){
                                        //some code here that modifies the selected node in TinyMCE
                                        tinyMCE.activeEditor.insertContent('[music_press_pro_artist artist_id="'+ jQuery('#artist-select .artists').val()+'"' +
                                            ' artist_songs="'+ jQuery('#artist-select .artist_songs').val()+'" ' +
                                            ' artist_videos="'+ jQuery('#artist-select .artist_videos').val()+'" ' +
                                            ' artist_album="'+ jQuery('#artist-select .artist_album').val()+'"' +
                                            ']');
                                        tinymce.activeEditor.windowManager.close();
                                    }
                                }
                            ]
                        });
                    }
                },
                {
                    text: 'Add List All Songs',
                    value: 'Add List All Songs',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Insert List Songs',
                            width:450,
                            height:300,
                            html :
                            '<div id="list-songs-select" class="list-songs-popup" tabindex="-1">' +
                            jQuery('#list_songs_select').html()+
                            '</div>',

                            buttons: [
                                {
                                    text: 'Cancel',
                                    onclick: 'close'
                                },
                                {
                                    text: 'Save',
                                    onclick: function(){
                                        //some code here that modifies the selected node in TinyMCE
                                        tinyMCE.activeEditor.insertContent('[music_press_pro_list_songs sl_postperpage="'+ jQuery('#list-songs-select .list_song_number').val()+'"' +
                                            ' sl_col="'+ jQuery('#list-songs-select .list-songs-col').val()+'" ' +
                                            ' sl_order="'+ jQuery('#list-songs-select .list-songs-order').val()+'" ' +
                                            ']');
                                        tinymce.activeEditor.windowManager.close();
                                    }
                                }
                            ]
                        });
                    }
                },
                {
                    text: 'Add Video Songs',
                    value: 'Add Video Songs',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Insert Video Songs',
                            width:450,
                            height:300,
                            html :
                            '<div id="video-songs-select" class="video-songs-popup" tabindex="-1">' +
                            jQuery('.video-songs-select').html()+
                            '</div>',

                            buttons: [
                                {
                                    text: 'Cancel',
                                    onclick: 'close'
                                },
                                {
                                    text: 'Save',
                                    onclick: function(){
                                        //some code here that modifies the selected node in TinyMCE
                                        tinyMCE.activeEditor.insertContent('[music_press_pro_video_songs vds_novts="'+ jQuery('#video-songs-select #vds-number').val()+'" '  +
                                            'vds_orderby="'+ jQuery('#video-songs-select #vds-orderby').val()+'" ' +
                                            'vds_order="'+ jQuery('#video-songs-select #vds-order').val()+'" ' +
                                            'vds_thumbnail="'+ jQuery('#video-songs-select #vds-thumbnail').val()+'" ' +
                                            'vds_views="'+ jQuery('#video-songs-select #vds-views').val()+'" ' +
                                            'vds_nii="'+ jQuery('#video-songs-select #vds-nii').val()+'" ' +
                                            ']');
                                        tinymce.activeEditor.windowManager.close();
                                    }
                                }
                            ]
                        });
                    }
                },
                {
                    text: 'Add List Artists',
                    value: 'Add List Artists',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Insert List Artists',
                            width:450,
                            height:300,
                            html :
                            '<div id="all-artist-select" class="all-artist-popup" tabindex="-1">' +
                            jQuery('.all-artist-select').html()+
                            '</div>',

                            buttons: [
                                {
                                    text: 'Cancel',
                                    onclick: 'close'
                                },
                                {
                                    text: 'Save',
                                    onclick: function(){
                                        //some code here that modifies the selected node in TinyMCE
                                        tinyMCE.activeEditor.insertContent('[music_press_pro_all_artist ar_orderby="'+ jQuery('#all-artist-select #ar-orderby').val()+'" '  +
                                            'ar_order="'+ jQuery('#all-artist-select #ar-order').val()+'" ' +
                                            'ar_avatar="'+ jQuery('#all-artist-select #ar-avatar').val()+'" ' +
                                            'ar_limit="'+ jQuery('#all-artist-select #ar-limit').val()+'"' +
                                            ']');
                                        tinymce.activeEditor.windowManager.close();
                                    }
                                }
                            ]
                        });
                    }
                }
                ]


        });
    });
})();
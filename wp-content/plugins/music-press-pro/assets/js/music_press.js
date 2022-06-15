;(function($){

    /**
     * jQuery function to prevent default anchor event and take the href * and the title to make a share popup
     *
     * @param  {[object]} e           [Mouse event]
     * @param  {[integer]} intWidth   [Popup width defalut 500]
     * @param  {[integer]} intHeight  [Popup height defalut 400]
     * @param  {[boolean]} blnResize  [Is popup resizeabel default true]
     */
    $.fn.customerPopup = function (e, intWidth, intHeight, blnResize) {

        // Prevent default anchor event
        e.preventDefault();

        // Set values for window
        intWidth = intWidth || '500';
        intHeight = intHeight || '400';
        strResize = (blnResize ? 'yes' : 'no');

        // Set title and open popup with focus on it
        var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
            strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,
            objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
    }

    /* ================================================== */

    $(document).ready(function ($) {
        $('.customer.share').on("click", function(e) {
            $(this).customerPopup(e);
        });
    });

    /* ===================================================== */

    $('.songs-character .directional').click(function(){
        var data_character = $(this).data('character'),
            data_limit = $(this).data('limit'),
            data_col = $(this).data('col'),
            ajax_content = $('#ls_content');
        if(data_character == 'all'){
            location.reload();
        }else{
            $.ajax({
                url: music_list_songs_ajax.url,
                type: 'POST',
                data: ({
                    action: 'music_list_character_ajax_action',
                    character: data_character,
                    column: data_col,
                    limit: data_limit

                }),
                success: function(data){
                    if (data){
                        ajax_content.html(data);
                    }else{
                        alert('error');
                    }
                }
            });
        }

    })
    // Add / Remove class active li tag
    $('.songs-character').on('click', '.directional', function() {
        $('.songs-character .directional.active').removeClass('active');
        $(this).addClass('active');
    });


}(jQuery));
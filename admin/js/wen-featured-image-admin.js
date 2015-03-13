var wfi_file_frame;
(function( $ ) {
	'use strict';

  jQuery(document).ready(function($) {

    // $('a.wfi-btn-add').css('border','2px red solid');

        // Uploads

        jQuery(document).on('click', 'a.wfi-btn-add', function( event ){

          var $this = $(this);

          event.preventDefault();

          // Create the media frame.
          wfi_file_frame = wp.media.frames.wfi_file_frame = wp.media({
            title: jQuery( this ).data( 'uploader_title' ),
            button: {
              text: jQuery( this ).data( 'uploader_button_text' ),
            },
            multiple: false  // Set to true to allow multiple files to be selected
          });



          // When an image is selected, run a callback.
          wfi_file_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            var attachment = wfi_file_frame.state().get('selection').first().toJSON();
            jQuery.post(
                WFI_OBJ.ajaxurl,
                {
                    action : 'wfi-add-featured-image',
                    post_ID : $this.data('post'),
                    attachment_ID : attachment.id
                },
                function( response ) {
                    console.log( response );
                }
            );
            // console.log(attachment);
            return;
            var image_field = $this.siblings('.wls-slide-image-id');
            image_field.val(attachment.id);
            var imgurl = attachment.url;
            if( 'undefined' != typeof attachment.sizes.thumbnail ){
              imgurl = attachment.sizes.thumbnail.url;
            }
            var image_preview_wrap = $this.siblings('.image-preview-wrap');
            image_preview_wrap.show();
            image_preview_wrap.find('.img-preview').attr('src',imgurl);
            // Hide upload button
            $this.hide();

          });

          // Finally, open the modal
          wfi_file_frame.open();
        });

  });

})( jQuery );

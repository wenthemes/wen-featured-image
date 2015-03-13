var wfi_file_frame;
(function( $ ) {
	'use strict';

  jQuery(document).ready(function($) {

    // Delete
    jQuery(document).on('click', 'a.wfi-btn-remove', function( event ){

      var $this = $(this);
      event.preventDefault();

      var confirmation = confirm('Are you sure?');
      if ( ! confirmation) {
        return false;
      }
      jQuery.post(
          WFI_OBJ.ajaxurl,
          {
              action : 'wfi-remove-featured-image',
              post_ID : $this.data('post')
          },
          function( response ) {
              console.log( response );
          }
      );


    });
    ///////////////////////

    // Add Handling
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
        return;

      });

      // Finally, open the modal
      wfi_file_frame.open();
    }); //end add handling

    // Change Handling
    jQuery(document).on('click', 'a.wfi-btn-change', function( event ){

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
                action : 'wfi-change-featured-image',
                post_ID : $this.data('post'),
                attachment_ID : attachment.id
            },
            function( response ) {
              if( 1 == response.status ){
                var target_id = 'wfi-block-wrap-' + response.post_ID;
                $('#'+target_id).hide().html(response.html).fadeIn();
              }
            }
        );
        return;

      });

      // Finally, open the modal
      wfi_file_frame.open();
    }); //end change handling

  });

})( jQuery );

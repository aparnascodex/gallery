jQuery( document ).ready( function( $ ) {
	//Doing some testing stuff

	jQuery('.connectedli').sortable();
	jQuery('.connectedli').disableSelection();
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id; 
	var uploaded_ids  = new Array();
	var uploaded_urls = new Array();

	var set_to_post_id = ''; // Set this
	jQuery('#upload_image_button').on('click', function( event ){
		event.preventDefault();
		
		if ( file_frame ) {
			
			file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
			
			file_frame.open();
			return;
		} else {
			
			wp.media.model.settings.post.id = set_to_post_id;
		}
		
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select images to upload',
			button: {
				text: 'Use this image',
			},
			multiple: 'add'
		});
		
		file_frame.on( 'select', function() {
			
			attachment = file_frame.state().get('selection');
			
		    attachment.map( function( attachment ) {

		        attachment = attachment.toJSON();
		        uploaded_ids.push(attachment.id);
				uploaded_urls.push(attachment.url);
		        img_ele =  "<li><img src='"+attachment.url+"' class='media-img'></li>";
		        jQuery('.connectedli').append(img_ele);
		    });
			
			wp.media.model.settings.post.id = wp_media_post_id;
		});
	
		file_frame.open();
	});
			
	jQuery( 'a.add_media' ).on( 'click', function() {

		wp.media.model.settings.post.id = wp_media_post_id;
				
	});
});
/*
 
Script using WordPress Media Uploader 

*/
jQuery(document).ready(function($) {
 	 var formfield,
		  customMedia = true,
		  origSendAttachment = wp.media.editor.send.attachment;

	$('.cp_upload').on('click', function(){
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = $(this);
		customMedia = true;
		wp.media.editor.send.attachment = function(props, attachment) {
			if(customMedia) {
				console.log(attachment.url);
				console.log(button.prev('input').val());
				button.prev('input').val(attachment.url);
			} else {
				return origSendAttachment.apply(this, [props, attachment] );
			};
		}

		wp.media.editor.open(button);
		return false;
	});
});

/*
 
Script using WordPress Media Uploader 

*/
jQuery(document).ready(function($) {
 
    /* Old Media Upload Script */
	 /*
	 var formfield;
 
    jQuery('.cp_upload').click(function() { 
        formfield = jQuery(this).prev('input'); 
		  console.log(formfield);
        tb_show('','media-upload.php?TB_iframe=true');
 
        return false;
 
    });
   
    window.old_tb_remove = window.tb_remove;
    window.tb_remove = function() {
        window.old_tb_remove(); 
        formfield=null;
    };
 
    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html){
        if (formfield) {
            fileurl = jQuery('img',html).attr('src');
            jQuery(formfield).val(fileurl);
            tb_remove();
        } else {
            window.original_send_to_editor(html);
        }
    };*/


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

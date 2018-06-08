jQuery(document).ready(function(){
	jQuery(".fileinput-preview.fileinput-exists.thumbnail").bind("DOMSubtreeModified",function(){
		console.log(jQuery(".fileinput-preview.fileinput-exists.thumbnail img").attr('src'));
		jQuery('#file-upload').val(jQuery(".fileinput-preview.fileinput-exists.thumbnail img").attr('src'));
	});

	jQuery(document).ajaxSuccess(function() {
		jQuery("#publications-upload-preview").bind("DOMSubtreeModified",function(){
			console.log(jQuery("#publications-upload-preview img").attr('src'));
			jQuery('#publications-upload').val(jQuery("#publications-upload-preview img").attr('src'));
		});
	});
		jQuery(document).ajaxSuccess(function() {
		jQuery("#partners-upload-preview").bind("DOMSubtreeModified",function(){
			console.log(jQuery("#partners-upload-preview img").attr('src'));
			jQuery('#partners-upload').val(jQuery("#partners-upload-preview img").attr('src'));
		});
	});
});
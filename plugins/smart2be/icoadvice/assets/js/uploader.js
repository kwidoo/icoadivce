jQuery(document).ready(function(){
	jQuery(".fileinput-preview.fileinput-exists.thumbnail").bind("DOMSubtreeModified",function(){
		console.log(jQuery(".fileinput-preview.fileinput-exists.thumbnail img").attr('src'));
		jQuery('#file-upload').val(jQuery(".fileinput-preview.fileinput-exists.thumbnail img").attr('src'));
	});
});
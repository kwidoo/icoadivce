jQuery(document).ready(function(){
	jQuery('#published').click(function(){
		jQuery(this).request('onPublish');
		console.log('toggled');
	});
});
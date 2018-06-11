jQuery(document).ajaxSuccess(function() {

	// removes content of modal
	jQuery(".modal").on("hidden.bs.modal", function(){
    	jQuery("#modalPopupBody").html("");
	});

	jQuery("#error").bind("DOMSubtreeModified",function(){
		jQuery('#error').addClass('alert-danger');
	});
	jQuery('.datepickers').datepicker({
      	autoclose: true
    })
});

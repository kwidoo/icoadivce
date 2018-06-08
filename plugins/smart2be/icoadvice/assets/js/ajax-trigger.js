jQuery(document).ajaxSuccess(function() {
	jQuery('.selectpicker').selectpicker();
	jQuery('.datetimepicker').datetimepicker();
	
	// removes content of modal
	jQuery(".modal").on("hidden.bs.modal", function(){
    	jQuery("#modalPopupBody").html("");
	});
});
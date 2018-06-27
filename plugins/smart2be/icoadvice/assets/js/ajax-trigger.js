jQuery(document).ajaxSuccess(function() {

	// removes content of modal
	jQuery(".modal").on("hidden.bs.modal", function(){
    	jQuery("#modalPopupBody").html("");
	});

	jQuery("#error").bind("DOMSubtreeModified",function(){
		  jQuery('#error').addClass('alert-danger');
	});

	jQuery('.datepickers').datepicker({
      	autoclose: true,
      	format: 'yyyy-mm-dd'
    });



	// TEAM Upload
	jQuery(document).on('change','#team-original', function(){
		file = jQuery('#team-original').prop('files')[0];
		fr = new FileReader();
      	fr.onload = receivedTeam;
      	fr.readAsDataURL(file);
	});
	function receivedTeam() {
    	jQuery('#team-preview').html('<img src="'+fr.result+'"  />');
    	jQuery('#team-file').html(jQuery('#team-original').prop('files')[0].name+'<br><small>128px x 128px</small><input type="hidden" name="team-filename" value="'+jQuery('#team-original').prop('files')[0].name+'">');
    	jQuery('#team-upload').val(fr.result);
    	jQuery('#team-value').addClass('hide');
    	jQuery('#team-preview').removeClass('hide');
    	jQuery('#team-remove').removeClass('hide');
  	}
  	jQuery(document).on('click','#team-remove', function(e){
  		jQuery('#team-preview').addClass('hide');
  		jQuery('#team-preview').html('');
    	jQuery('#team-value').removeClass('hide');
    	jQuery('#team-value img').attr('src','/plugins/smart2be/icoadvice/assets/images/no-photo-64x64.svg');
    	jQuery('#team-file').html('');
  		jQuery('#team-upload').val();
    	jQuery('#team-remove').addClass('hide');
  		e.stopPropagation();

  	});    


  	// Publications Upload
	jQuery(document).on('change','#publications-original', function(){
		file = jQuery('#publications-original').prop('files')[0];
		fr = new FileReader();
      	fr.onload = receivedPublications;
      	fr.readAsDataURL(file);
	});
	function receivedPublications() {
    	jQuery('#publications-preview').html('<img src="'+fr.result+'"  />');
    	jQuery('#publications-file').html(jQuery('#publications-original').prop('files')[0].name+'<br><small>128px x 64px</small><input type="hidden" name="publications-filename" value="'+jQuery('#publications-original').prop('files')[0].name+'">');
    	jQuery('#publications-upload').val(fr.result);
    	jQuery('#publications-value').addClass('hide');
    	jQuery('#publications-preview').removeClass('hide');
    	jQuery('#publications-remove').removeClass('hide');
  	}
  	jQuery(document).on('click','#publications-remove', function(e){
  		jQuery('#publications-preview').addClass('hide');
  		jQuery('#publications-preview').html('');
    	jQuery('#publications-value').removeClass('hide');
    	jQuery('#publications-value img').attr('src','/plugins/smart2be/icoadvice/assets/images/no-logo-128x64.svg');
    	jQuery('#publications-file').html('');
  		jQuery('#publications-upload').val();
    	jQuery('#publications-remove').addClass('hide');
  		e.stopPropagation();

  	});    

  	// partners Upload
	jQuery(document).on('change','#partners-original', function(){
		file = jQuery('#partners-original').prop('files')[0];
		fr = new FileReader();
      	fr.onload = receivedPartners;
      	fr.readAsDataURL(file);
	});
	function receivedPartners() {
    	jQuery('#partners-preview').html('<img src="'+fr.result+'"  />');
    	jQuery('#partners-file').html(jQuery('#partners-original').prop('files')[0].name+'<br><small>128px x 64px</small><input type="hidden" name="partners-filename" value="'+jQuery('#partners-original').prop('files')[0].name+'">');
    	jQuery('#partners-upload').val(fr.result);
    	jQuery('#partners-value').addClass('hide');
    	jQuery('#partners-preview').removeClass('hide');
    	jQuery('#partners-remove').removeClass('hide');
  	}
  	jQuery(document).on('click','#partners-remove', function(e){
  		jQuery('#partners-preview').addClass('hide');
  		jQuery('#partners-preview').html('');
    	jQuery('#partners-value').removeClass('hide');
    	jQuery('#partners-value img').attr('src','/plugins/smart2be/icoadvice/assets/images/no-logo-128x64.svg');
    	jQuery('#partners-file').html('');
  		jQuery('#partners-upload').val();
    	jQuery('#partners-remove').addClass('hide');
  		e.stopPropagation();

  	});    
});

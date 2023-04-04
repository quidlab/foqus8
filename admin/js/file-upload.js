$(document).ready(function(){

	// File create form submit on click
	$('#fileCreate').on('submit', function(event){
		event.preventDefault();
		$('#submitFile').hide();
		
		var descriptionEng = $('#descriptionEng').val();
		var descriptionThai = $('#descriptionThai').val();
		// var agnamethai = $('#agnamethai').val();
		
		var formData = new FormData(this);

		//if(agid!='' && formula !='' && agnameeng!='' && agnamethai!='' && info!='' && fullshares!='' && agcomp!='' && vote!='' && inivote!='' ){
			$.ajax({
				type: 'POST',
				url: "files-script.php",
				data: formData,
				cache:false,
                contentType: false,
                processData: false,
				success: function(regResponse){
					console.log(regResponse);
					let regResponseData = JSON.parse(regResponse);
                    if(regResponseData.message == '1'){
						new PNotify({
							title: 'Success!',
							text: regResponseData.status,
							type: 'success',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
						$('#submitFile').show();
                    }
					else{
						new PNotify({
							title: 'Failed!',
							text: regResponseData.status,
							type: 'danger',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
					}
					$("#fileCreate")[0].reset();
					$('#submitFile').show();
				}
			});
		//}
	});
	
	
	// File edit form submit on click
	$('#fileEdit').on('submit', function(event){
		event.preventDefault();
		$('#editFile').hide();
		
		var fid = $('#fid').val();
		var descriptionEng = $('#descriptionEng').val();
		var descriptionThai = $('#descriptionThai').val();
		
		var formData = new FormData(this);
		//if(agid!='' && formula !='' && agnameeng!='' && agnamethai!='' && info!='' && fullshares!='' && agcomp!='' && vote!='' && inivote!='' ){
			$.ajax({
				type: 'POST',
				url: "files-script.php",
				data: formData,
				cache:false,
                contentType: false,
                processData: false,
				success: function(regResponse){
					console.log(regResponse);
					let regResponseData = JSON.parse(regResponse);
                    if(regResponseData.message == '1'){
						new PNotify({
							title: 'Success!',
							text: regResponseData.status,
							type: 'success',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
						$('#editFile').show();
                    }
					else{
						new PNotify({
							title: 'Registration Failed!',
							text: regResponseData.status,
							type: 'danger',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
					}
					//$("#fileEdit")[0].reset();
					$('#editFile').show();
				}
			});
		//}
	});
	
	
});
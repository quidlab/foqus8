$(document).ready(function(){
	//sending bulk emails
	var inProgressHTML = `<button>In Progress <i class="fa fa-paper-plane"></i></button>`;
	var sendEmailHTML = `<button class="sendingEmail">Sending Emails <i class="fa fa-paper-plane"></i></button>`;
	$('.sendingEmail').click(function(){
		var ele = $('.sendingEmail')[0].innerHTML;
		if(ele == 'Send 1000 Emails <i class="fa fa-paper-plane"></i>'){
			$('.sendingEmail').innerHTML="In Progress...";
			$.ajax({
				url: "../sendemail/bulk-email-sent.php",
				method: "POST",
				data: {'status': ele},
				success: function(data){
					renderTable();
					new PNotify({
						title: 'Success!',
						text: data,
						type: 'success',
						nonblock: {
						  nonblock: true
						},
						styling: 'bootstrap3'
					});
					$('.sendingEmail').innerHTML= ele;
				},
				error: function(error){
					new PNotify({
						title: 'Request Failed!',
						text:  'Emails not sent, try again',
						type: 'danger',
						nonblock: {
						  nonblock: true
						},
						styling: 'bootstrap3'
					});
					$('.sendingEmail').innerHTML="Bad Request!";
				}
			});
		}
		else{
			$('.sendingEmail').innerHTML="Bad Request!";
			new PNotify({
				title: 'Request Failed!',
				text:  'Emails not sent, try again',
				type: 'danger',
				nonblock: {
				  nonblock: true
				},
				styling: 'bootstrap3'
			});
		}
	});
	
	//update all non approved users password
	$('#updateButton').click(function(){
		var ele = $('#updateButton')[0].innerHTML;
		$.ajax({
			url: "updateData_egm.php",
			method: "POST",
			data: {'updateEGMData': ele},
			success: function(data){
				renderTable();
				new PNotify({
					title: 'Success!',
					text: data,
					type: 'success',
					nonblock: {
					  nonblock: true
					},
					styling: 'bootstrap3'
				});
				$('#updateButton').show();
			},
			error: function(error){
				new PNotify({
					title: 'Updates Failed!',
					text:  'Details not updated, try again',
					type: 'danger',
					nonblock: {
					  nonblock: true
					},
					styling: 'bootstrap3'
				});
				$('#updateButton').show();
			}
		});
	});

// presenter create form submit on click
$('#presenterCreate').on('submit', function(event){
		event.preventDefault();
		$('#submitPresenter').hide();
		var title = $('#title').val();
		var fname = $('#fname').val();
		var lname = $('#lname').val();
		var uid = $('#uid').val();
		var pass = $('#pass').val();
		var role = $('#role').val();
		var email = $('#email').val();
		var phone = $('#phone').val();
		if(title!='' && fname !='' && lname!='' && uid!='' && pass!='' && email!='' && role!='' && phone!=''){
			$.ajax({
				url: "presenters-script.php",
				method: "POST",
				data: {'title': title, 'fname': fname, 'lname': lname, 'uid': uid, 'pass': pass, 'email': email, 'role': role, 'phone': phone},
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
						$('#submitPresenter').show();
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
					$("#presenterCreate")[0].reset();
					$('#submitPresenter').show();
				}
			});
		}
	});
	
	// presenter create form submit on click
	$('#presenterEdit').on('submit', function(event){
		event.preventDefault();
		$('#editPresenter').hide();
		var title = $('#title').val();
		var fname = $('#fname').val();
		var lname = $('#lname').val();
		var uuid = $('#uuid').val();
		var pass = $('#pass').val();
		var email = $('#email').val();
		var role = $('#role').val();
		var preid = $('#preid').val();
		var phone = $('#phone').val();
		if(title!='' && fname !='' && lname!='' && uuid!='' && pass!='' && email!='' && role!='' && preid != '' && phone != ''){
			$.ajax({
				url: "presenters-script.php",
				method: "POST",
				data: {'title': title, 'fname': fname, 'lname': lname, 'uuid': uuid, 'pass': pass, 'email': email, 'role': role, 'preid': preid, 'phone': phone},
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
						$('#editPresenter').show();
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
					//$("#presenterEdit")[0].reset();
					$('#editPresenter').show();
				}
			});
		}
	});
	
	//egm data updates
	$('#egmForm').on('submit', function(event){
		event.preventDefault();
		$('#myModal').modal('toggle');
		var egmid = $('#egmid').val();
		var email = $('#email').val();
		var phone = $('#phone').val();
		//var proxy = $('#proxy').find(":selected").val(); changed by kamal below line
		var proxy = $( "#proxy" ).val();
		//alert(proxy);
		var proxy_name = $('#proxy_name').val();
		//var proxy_type = $('#proxy_type').find(":selected").val(); changed by kamal below line
		var proxy_type = $( "#proxy_type" ).val();
		//var pass = $('#pass1').val();
		//var pass2 = $('#pass2').val();
		console.log(email);
		console.log(phone);
		console.log(proxy);
		console.log(proxy_name);
		console.log(proxy_type);
		//reset dropdown values for next for load by kamal
		$("#proxy").val($("#proxy option:first").val());
		$("#proxy_type").val($("#proxy_type option:first").val());
		$("#proxy_name").val("");
		//$('#phone').val()='';

		//if( egmid!='' && email!='' && phone!='' && proxy_name!='' && proxy_type!='' && proxy!=''){ // changed by kamal below line
			if( egmid!='' && email!='' && phone!=''  && proxy!=''){
			// if(pass == pass2){
				$.ajax({
					url: "updateData_egm.php",
					method: "POST",
					data: {'email': email, 'phone': phone, 'proxy': proxy, 'proxy_name': proxy_name, 'proxy_type': proxy_type, 'egmid': egmid},
					success: function(data){
						renderTable();
						new PNotify({
							title: 'Success!',
							text: data,
							type: 'success',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
					},
					error: function(error){
						new PNotify({
							title: 'Error!',
							text: error,
							type: 'error',
							nonblock: {
							  nonblock: true
							},
							styling: 'bootstrap3'
						});
					}
				});			
			// }
			// else{
			// 	new PNotify({
			// 		title: 'Error!',
			// 		text: 'Password not matched',
			// 		type: 'error',
			// 		nonblock: {
			// 		  nonblock: true
			// 		},
			// 		styling: 'bootstrap3'
			// 	});
			// }
		}
		else{
			alert('All field required');

		}
	});
	
	$('body').on('click', '.onlineStatus', function(e){
		var ele = $(e.currentTarget);
		var loginid = ele.data('loginid')
		console.log(loginid);
		$.ajax({
			url: "updateData_egm.php",
			method: "POST",
			data: {'loginid': loginid},
			success: function(data){
				renderTable();
				new PNotify({
					title: 'Success!',
					text: data,
					type: 'success',
					nonblock: {
					  nonblock: true
					},
					styling: 'bootstrap3'
				});
			}
		});
	});
	
	$('body').on('click', '.emailSent', function(e){
		var ele = $(e.currentTarget);
		var emailid = ele.data('emailid')
		console.log(emailid);
		$.ajax({
			url: "../sendemail/email-sent.php",
			method: "POST",
			data: {'id': emailid},
			success: function(data){
				renderTable();
				new PNotify({
					title: 'Success!',
					text: data,
					type: 'success',
					nonblock: {
					  nonblock: true
					},
					styling: 'bootstrap3'
				});
			}
		});
	});
	
	// presenter create form submit on click
$('#userCreate').on('submit', function(event){
		event.preventDefault();
		$('#submitUser').hide();
		var uid = $('#uid').val();
		var uName = $('#uName').val();
		var uPass = $('#uPass').val();
		var uRole = $('#uRole').val();
		var uEmail = $('#uEmail').val();
		var phone = $('#phone').val();
		if(uid!='' && uName!='' && uPass!='' && uRole!='' && uEmail!='' && phone!=''){
			$.ajax({
				url: "User-submit.php",
				method: "POST",
				data: {'uid': uid, 'uName': uName, 'uPass': uPass, 'uRole': uRole, 'uEmail': uEmail, 'phone': phone},
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
						$('#submitUser').show();
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
					$("#userCreate")[0].reset();
					$('#submitUser').show();
				}
			});
		}
	});
	
	$('#userEdit').on('submit', function(event){
		event.preventDefault();
		$('#editUser').hide();
		var uid = $('#uid').val();
		var uname = $('#uname').val();
		var uPass = $('#uPass').val();
		var uEmail = $('#uEmail').val();
		var uRole = $('#uRole').val();
		var OldUserID = $('#OldUserID').val();
		var phone = $('#phone').val();
		
		if(uid!='' && uname!='' && uPass!='' && uEmail!='' && uRole!='' && OldUserID!='' && phone!=''){
			$.ajax({
				url: "User-submit.php",
				method: "POST",
				data: {'uid': uid, 'uname': uname, 'uPass': uPass, 'uRole': uRole, 'uEmail': uEmail, 'OldUserID': OldUserID, 'phone': phone},
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
						$('#editUser').show();
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
					$('#editUser').show();
				}
			});
		}
	});
	
	// presenter create form submit on click
$('#agendaCreate').on('submit', function(event){
		event.preventDefault();
		$('#submitAgenda').hide();
		var agid = $('#agid').val();
		var formula = $('#formula').val();
		var agnameeng = $('#agnameeng').val();
		var agnamethai = $('#agnamethai').val();
		var info = $('#info').val();
		var fullshares = $('#fullshares').val();
		//var agcomp = $('#agcomp').val();
		var vote = $('#vote').val();
		var inivote = $('#inivote').val();
		//if(agid!='' && formula !='' && agnameeng!='' && agnamethai!='' && info!='' && fullshares!='' && agcomp!='' && vote!='' && inivote!='' ){
			$.ajax({
				url: "agendas-script.php",
				method: "POST",
				data: {'agid': agid, 'formula': formula, 'agnameeng': agnameeng, 'agnamethai': agnamethai, 'info': info, 'fullshares': fullshares, 'vote': vote, 'inivote': inivote},
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
						$('#submitAgenda').show();
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
					$("#agendaCreate")[0].reset();
					$('#submitAgenda').show();
				}
			});
		//}
	});
	
	
		// presenter create form submit on click
$('#agendaEdit').on('submit', function(event){
		event.preventDefault();
		$('#editAgenda').hide();
		var aid = $('#aid').val();
		var agnid = $('#agnid').val();
		var formula = $('#formula').val();
		var agnameeng = $('#agnameeng').val();
		var agnamethai = $('#agnamethai').val();
		var info = $('#info').val();
		var fullshares = $('#fullshares').val();
		//var agcomp = $('#agcomp').val();
		var vote = $('#vote').val();
		var inivote = $('#inivote').val();
		//if(agid!='' && formula !='' && agnameeng!='' && agnamethai!='' && info!='' && fullshares!='' && agcomp!='' && vote!='' && inivote!='' ){
			$.ajax({
				url: "agendas-script.php",
				method: "POST",
				data: {'aid': aid, 'agnid': agnid, 'formula': formula, 'agnameeng': agnameeng, 'agnamethai': agnamethai, 'info': info, 'fullshares': fullshares, 'vote': vote, 'inivote': inivote},
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
						$('#editAgenda').show();
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
					//$("#agendaEdit")[0].reset();
					$('#editAgenda').show();
				}
			});
		//}
	});
	
	//email sent for presenter script
	$('body').on('click', '.emailSentPres', function(e){
		var ele = $(e.currentTarget);
		var emailid = ele.data('emailid')
		console.log(emailid);
		$.ajax({
			url: "../sendemail/email-sent-pres.php",
			method: "POST",
			data: {'id': emailid},
			success: function(data){
				renderTable();
				new PNotify({
					title: 'Success!',
					text: data,
					type: 'success',
					nonblock: {
					  nonblock: true
					},
					styling: 'bootstrap3'
				});
			}
		});
	});
	
		$('body').on('click', '.emailSentGuest', function(e){
		var ele = $(e.currentTarget);
		var emailid = ele.data('emailid')
		console.log(emailid);
		$.ajax({
			url: "../sendemail/email-sent-guest.php",
			method: "POST",
			data: {'id': emailid},
			success: function(data){
				renderTable();
				new PNotify({
					title: 'Success!',
					text: data,
					type: 'success',
					nonblock: {
					  nonblock: true
					},
					styling: 'bootstrap3'
				});
			}
		});
	});
	
	
});
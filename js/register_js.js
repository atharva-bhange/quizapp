$(document).ready(function (){

	function display_msg(msg , color){
		$("#msg_box").append('<p id="msg" style="color:'+color+';"">'+msg+'</p>');
		
		setTimeout(function (){$("#msg").remove();} , 5000);
	}

	$('#submit').click(function (){
		$.post('php/register.php',
			{email : $('#email').val() ,pass1 : $('#pass1').val(),pass2 : $('#pass2').val() },
			function (result){
				var data = JSON.parse(result);
				if (data.is_error){
					display_msg(data.msg , 'red');
				}else{
					$(location).attr('href', 'index.html');
				}
			}
			);
	});

});
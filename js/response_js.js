$(document).ready(function(){

	$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)')
                      .exec(window.location.search);

    return (results !== null) ? results[1] || 0 : false;
	}

	var responder_id = $.urlParam('id');
	var quiz_id = $.urlParam('quiz_id');

	$.ajax({
		url: 'php/get_responses.php?id='+responder_id+'&quiz_id='+quiz_id,
		method : 'get',
		success: function (data){
			//code
			var result = JSON.parse(data);
			console.log(result);
			var name =result[0][0] ;

			$('.name').append('Response from '+name);	
			for (var i = 0; i < result.length; i++) {
				var question = result[i];
				if (question[1]){
					$("#questions").append('<div class="question"><h5>'+question[2]+'<span class="msg_crct">Correct</span></h5><p class="crct_selected">Selected Option: '+question[3]+'</p></div>');
				}else{
					$("#questions").append('<div class="question"><h5>'+question[2]+'<span class="msg_wrong">Wrong</span></h5><p class="wrong_selected">Selected Option: '+question[3]+'</p><p class="crct_selected">Correct Option: '+question[4]+'</p></div>');
				}

			}
		}
	});


});
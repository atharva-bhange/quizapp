$(document).ready(function (){

	$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)')
                      .exec(window.location.search);

    return (results !== null) ? results[1] || 0 : false;
	}

	var quiz_id = $.urlParam('id');
	
	$.ajax({
		url : 'php/get_responders.php?id='+quiz_id,
		method : 'get',
		success: function (data){
			var responders = JSON.parse(data)
			if (responders.length != 0){
				for (var i = 0; i < responders.length ; i++){
					$('#responders').append('<p><a href="response.html?id='+responders[i]['responder_id']+'&quiz_id='+quiz_id+'">'+responders[i]['name']+'</a></p>')
				}
			}
		}
	})
});
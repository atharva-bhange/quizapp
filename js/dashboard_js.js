
$(document).ready(function(){

    $.ajax({
        url: 'php/check_user.php',
        method: 'POST',
        success: function(data) {
            if (data == '0') {
                window.location.href = "index.html"
            } else if (data == '1') {
                //console.log("got 1");
            } else {
                //console.log(data);
            }
        }
    })

    $.ajax({
        url: 'php/get_quizs.php',
        method: 'GET',
        success: function (data){
            var quiz_data = JSON.parse(data);
            if (quiz_data.length > 0){
                for (var i = 0; i < quiz_data.length ; i++){
                    $("#quiz_list").append(
                        '<div class="quiz"><h4>'+quiz_data[i]['name']+'</h4><a href="responses.html?id='+quiz_data[i]['quiz_id']+'">Responses</a><p>Quiz URL: <a href="php/quiz.php/?id='+quiz_data[i]['quiz_id']+'">Click Here</a></p></div>'
                        );
                }
            }
        }
    });

})


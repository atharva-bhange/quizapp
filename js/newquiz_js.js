$(document).ready(function () {

	var no_question = 0;

	// Code used to add questions
	$('.add_question').click(function (){
		no_question++;
		$("#question_box").append('<div class="question" id="'+no_question+'"><label>Question  :</label><input type="text" name="question_'+no_question+'"><input type="button" id="" class="btn btn-success add_option" value="+"><input type="hidden" name="no_option_'+no_question+'" value="1"><div class="options"><h5>Options</h5><input type="text" name="option_'+no_question+'_1"><input type="radio" name="correct_'+no_question+'" value="1"><br></div></div>');
		
		$("#no_question").val(no_question);
	});

	// this code is used to add options for each question seperately.
    $(document.body).on('click', '.add_option', function(e) {
    	var no_options = $(this).next();
    	no_options.val(parseInt(no_options.val())+1);
    	var option_no = no_options.val();

    	var question_no = $(this).parent().attr('id');

    	var option_box = $(this).next().next();
		option_box.append('<input type="text" name="option_'+parseInt(question_no)+'_'+option_no+'"><input type="radio" name="correct_'+no_question+'" value="'+option_no+'"><br>');
    });

});
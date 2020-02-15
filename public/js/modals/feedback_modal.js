$( "#feedback_modal-open" ).click(function() {
  $("#feedback_modal").modal("toggle");
});

$('#feedback_modal-form').on('submit', function(e) {
    e.preventDefault();
    var score = $('#antelope-square').val();
    var feedback = $('#feedback_modal-feedback').val();

    $.ajax({
      type: 'POST',
      url: $url_submit_feedback,
      data: { score:score, feedback:feedback },
      success: function() {
        var toast_heading = "Feedback Recorded!";
        var toast_text = "Thank you for improving AntelopePHP!";
        var toast_icon = "success";
        var toast_color = "#f96868";
        globalToast(toast_heading, toast_text, toast_icon, toast_color);
        $("#feedback_modal").modal("toggle");
        $("#feedback_notsubmitted_div").prop('hidden', true);
        },
      error: function(data) {
        var toast_heading = "Feedback Recording Failed!";
        var toast_text = "This form is just too much for the system.";
        var toast_icon = "error";
        var toast_color = "#f2a654";
        globalToast(toast_heading, toast_text, toast_icon, toast_color)
        var errors = data['responseJSON'].errors;
        console.log(errors);
    }
  });
});
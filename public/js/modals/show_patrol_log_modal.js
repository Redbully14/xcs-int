$table = $($activity_table);
$table.on('click', '#ajax_view_patrol_log_open', function () {

var id = $(this).val();

  $.ajax({
     type: "POST",
     url: $url_show_patrol_log+id,
     success: function(data){
       console.log(data);
        // $("#profile-username-field").val(data['username']);
        if(data['department_id'] == null) {
            var uniqueunitnumber = data['user_name'];
        } else var uniqueunitnumber = data['user_name']+' '+data['department_id'];
        $("#ajax_view_patrol_log").modal("toggle");
        $("#ajax-patrol-log-by").empty();
        $("#ajax-patrol-log-by").append(uniqueunitnumber);
        $("#ajax_submit_edit_patrol_log-button").val(id);
        $("#ajax-patrol-website-id").empty();
        $("#ajax-patrol-website-id").append(data['website_id']);
        $("#ajax-input-patrol-log-type").val(data['type']).change();
        $("#ajax-input-patrol-log-start-date").val(data['patrol_start_date']);
        $("#ajax-input-patrol-log-end-date").val(data['patrol_end_date']);
        $("#ajax-input-patrol-start-time").val(data['start_time']);
        $("#ajax-input-patrol-end-time").val(data['end_time']);
         $("#ajax-input-patrol-total-time").val(data['total_time'] + ' hours');
        $("#ajax-input-patrol-details").val(data['details']);
        var patrol_area = JSON.parse(data['patrol_area']);
        var patrol_area_with_space = patrol_area.join(', ');
        $("#ajax-input-patrol-area").val(patrol_area_with_space);
        $("#ajax-input-patrol-priorities").val(data['priorities']);
        var flags = JSON.parse(data['flag']);
        if (flags[0][0]) {
            $("#ajax-span-self-flag").html('Yes').css('color', 'red');
            $("#ajax-textarea-self-flag").val(flags[1][0]).attr('rows', 6);
         } else {
            $("#ajax-span-self-flag").html('No').css('color', '');
            $("#ajax-textarea-self-flag").val(flags[1][0]).attr('rows', 1);
         }
         if (flags[0][1]) {
             $("#ajax-span-auto-flag").html('Yes').css('color', 'red');
             $("#ajax-textarea-auto-flag").val(flags[1][1]).attr('rows', 6);
         } else {
             $("#ajax-span-auto-flag").html('No').css('color', '');
             $("#ajax-textarea-auto-flag").val(flags[1][1]).attr('rows', 1);
         }
     }
  }).done(function(data) {});
});

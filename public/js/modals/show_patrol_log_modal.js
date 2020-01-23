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
        $("#ajax-patrol-website-id").empty();
        $("#ajax-patrol-website-id").append(data['website_id']);
        $("#ajax-input-patrol-log-type").val(data['type']).change();
        $("#ajax-input-patrol-log-start-date").val(data['patrol_start_date']);
        $("#ajax-input-patrol-log-end-date").val(data['patrol_end_date']);
        $("#ajax-input-patrol-start-time").val(data['start_time']);
        $("#ajax-input-patrol-end-time").val(data['end_time']);
        $("#ajax-input-patrol-details").val(data['details']);
     }
  }).done(function(data) {});
});
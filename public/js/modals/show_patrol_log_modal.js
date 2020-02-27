var id = null;

$table = $($activity_table);
$table.on('click', '#ajax_view_patrol_log_open', function () {

var elements = [
  '#ajax-input-patrol-log-type',
  '#ajax-input-patrol-log-start-date',
  '#ajax-input-patrol-log-end-date',
  '#ajax-input-patrol-start-time',
  '#ajax-input-patrol-end-time',
  '#ajax-input-patrol-details',
  '#ajax-input-patrol-area',
  '#ajax-input-patrol-priorities',
];

for (var element in elements) {
  $(elements[element]).prop("disabled", true); // Element(s) are now disabled again.
}
$('#ajax_edit_patrol_log-button').prop('hidden', false);
$('#ajax_submit_edit_patrol_log-button').prop('hidden', true);

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
        $("#delete_patrol_log_btn").val(id);
        $("#ajax-patrol-website-id").empty();
        $("#ajax-patrol-website-id").append(data['website_id']);
        $("#ajax-input-patrol-log-type").val(data['type']).change();
        $("#ajax-input-patrol-log-start-date").val(data['patrol_start_date']);
        $("#ajax-input-patrol-log-end-date").val(data['patrol_end_date']);
        $("#ajax-input-patrol-start-time").val(data['start_time']);
        $("#ajax-input-patrol-end-time").val(data['end_time']);
         $("#ajax-input-patrol-total-time").val(data['total_time']);
        $("#ajax-input-patrol-details").val(data['details']);
        var patrol_area = JSON.parse(data['patrol_area']);
        $('#ajax-input-patrol-area').val(patrol_area);
        $('#ajax-input-patrol-area').trigger('change');
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
        $('.select2-search__field').css('width', '0');
        $('.select2-selection').css('background-color', '#2A3038');
     }
  }).done(function(data) {});
});
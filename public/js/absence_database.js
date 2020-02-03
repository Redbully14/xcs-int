$(function() {
  $('#ajax_absence_database_AR-table').DataTable({
   ordering: true,
   serverSide: true,
   searching: false,
   order: [[ 0  , "desc" ]],
   ajax: $url,
   columns: [
    { data: 'id', name: 'id', render: function (data, type, row) {
      return  $absence_id + data;
    } },
    { data: 'name_department_id', name: 'name_department_id' },
    { data: 'website_id', name: 'website_id' },
    { data: 'start_end_date', name: 'start_end_date' },
    { data: 'forum_post', name: 'forum_post' },
    { data: 'id', render: function(data, type, row) { return '<button class="btn btn-social-icon btn-success" id="absence_btn_approve" value="'+data+'"><i class="mdi mdi-check"></i></button> <button class="btn btn-social-icon btn-danger" id="absence_btn_block" value="'+data+'"><i class="mdi mdi-minus-circle"></i></button>'; } }
   ],
  });
});

var table = $('#ajax_absence_database_AR-table');
table.on('click', '#absence_btn_approve', function () {
  var id = $(this).val();
  $.ajax({
    type: 'POST',
    url: $url_absence_btn_approve + id,
    success: function() {
      var toast_heading = "Leave of Absence Approved!";
      var toast_text = "The Leave of Absence has been approved.";
      var toast_icon = "success";
      var toast_color = "#f96868";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
    }
  })
});
table.on('click', '#absence_btn_block', function () {
  var id = $(this).val();
  return window.location.href = $url_absence_btn_block+id;
});
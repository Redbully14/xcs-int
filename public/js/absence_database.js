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
    { data: 'id', render: function(data, type, row) { return '<button class="btn btn-outline-primary" id="ajax_view_patrol_log_open" value="'+data+'"><i class="mdi mdi-eye"></i> View</button>'; } }
   ],
  });
});
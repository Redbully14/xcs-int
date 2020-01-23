$(function() {
  $('#tableElement').DataTable({
   ordering: true,
   serverSide: true,
   searching: false,
   order: [[ 0  , "desc" ]],
   ajax: $url,
   columns: [
    { data: 'id', name: 'id', render: function (data, type, row) {
      return  $patrol_id + data;
    } },
    { data: 'name_department_id', name: 'name_department_id' },
    { data: 'website_id', name: 'website_id' },
    { data: 'patrol_start_end_date', name: 'patrol_start_end_date' },
    { data: 'start_time', name: 'start_time' },
    { data: 'end_time', name: 'end_time' },
    { data: 'details', name: 'details', render: function (data, type, row) {
      var allowedLength = 35;
      if (data.length >= allowedLength) {
        return data.substr(0, allowedLength)+'...';
      } else {
        return data;
      };
    } },
    { data: 'id', render: function(data, type, row) { return '<button class="btn btn-outline-primary" id="ajax_view_patrol_log_open" value="'+data+'"><i class="mdi mdi-eye"></i> View</button>'; } }
   ],
  });
});
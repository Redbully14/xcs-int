$(function() {
  $('#tableElement').DataTable({
   ordering: true,
   serverSide: true,
   searching: false,
   order: [[ 0  , "desc" ]],
   ajax: baseURL + '/activity/collection/',
   columns: [
    { data: 'id', name: 'id', render: function (data, type, row) {
      return  $patrol_id + data;
    } },
    { data: 'name_department_id', name: 'name_department_id' },
    { data: 'website_id', name: 'website_id' },
    { data: 'patrol_start_end_date', name: 'patrol_start_end_date' },
    { data: 'start_time', name: 'start_time' },
    { data: 'end_time', name: 'end_time' },
    { data: 'total_time', name: 'total_time' },
    { data: 'details', name: 'details', render: function (data, type, row) {
      var allowedLength = 35;
      if (data.length >= allowedLength) {
        return data.substr(0, allowedLength)+'...';
      } else {
        return data;
      };
    } },
    {data: 'flag', render: function (data, type, row) {
        var flag = JSON.parse(data.replace(/&quot;/g,'"'));
            // Positive Flag
        if (flag[0][0] || flag[0][1]) {
            // Resolved Flag
            if (flag[0][2]) {
                return 'Resolved';
            // Unresolved Flag
            } else {
                return 'Yes';
            }
        } else {
            return 'No';
        }
    }},
    { data: 'id', render: function(data, type, row) { return '<button class="btn btn-outline-primary" id="ajax_view_patrol_log_open" value="'+data+'"><i class="mdi mdi-eye"></i> View</button><br><br><button class="btn btn-outline-warning" id="ajax_edit_flags_open" value="'+data+'"><i class="mdi mdi-alarm-light-outline"></i> Flags</brbutton>'; }}
   ],
    "createdRow": function( row, data, dataIndex ) {
       var flag = JSON.parse(data.flag.replace(/&quot;/g,'"'));
       // Positive Flag
       if (flag[0][0] || flag[0][1]) {
           // Resolved Flag
           if (flag[0][2]) {
               $(row).css('background-color', 'rgba(72, 1, 1, 0.15)');
           // Unresolved Flag
           } else {
               $(row).css('background-color', 'rgba(72, 1, 1, 1.0)');
           }
       }
    }
  });
});

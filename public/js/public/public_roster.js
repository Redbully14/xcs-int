$(function() {
  $('#public_roster-admins').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: $url_admins,
   columns: [
    { data: 'name', name: 'name' },
    { data: 'department_id', name: 'department_id' },
    { data: 'website_id', name: 'website_id' },
    { data: 'rank', name: 'rank' },
    { data: 'status', name: 'status' },
    { data: 'monthly_hours', name: 'monthly_hours' },
    { data: 'monthly_logs', name: 'monthly_logs' },
    { data: 'advanced_training', name: 'advanced_training' },
    { data: 'requirements', name: 'requirements' },
   ],
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(72, 1, 1, 1.0)');
    },
    "bInfo" : false,
  });
});

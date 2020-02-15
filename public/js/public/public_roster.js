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
       $(row).css('background-color', 'rgb(1, 1, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#public_roster-seniorstaff').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: $url_senior_staff,
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
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#public_roster-staff').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: $url_staff,
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
       $(row).css('background-color', 'rgba(70, 53, 1, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });


  $('#public_roster-staffintraining').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: $url_staff_in_training,
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
       $(row).css('background-color', 'rgba(1, 70, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });
});

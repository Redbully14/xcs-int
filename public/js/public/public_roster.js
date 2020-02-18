$(function() {

  var columnsArray = [
    { data: 'name', name: 'name', width: "150px", className: 'text-wrap' },
    { data: 'department_id', name: 'department_id', width: "80px", className: 'text-wrap' },
    { data: 'website_id', name: 'website_id', width: "60px", className: 'text-wrap' },
    { data: 'rank', name: 'rank', width: "190px", className: 'text-wrap' },
    { data: 'status', name: 'status', width: "55px", className: 'text-wrap' },
    { data: 'monthly_hours', name: 'monthly_hours', width: "70px", className: 'text-wrap' },
    { data: 'monthly_logs', name: 'monthly_logs', width: "60px", className: 'text-wrap' },
    { data: 'advanced_training', name: 'advanced_training', width: "70px", className: 'text-wrap' },
    { data: 'requirements', name: 'requirements' },
   ];

  $('#public_roster-admins').DataTable({
   "autoWidth": false,
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: $url_admins,
   columns: columnsArray,
   "createdRow": function( row, data, dataIndex ) {
     $(row).css('background-color', 'rgba(70, 1, 1, 1.0)');
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
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(70, 36, 1, 1.0)');
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
   columns: columnsArray,
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
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 70, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#public_roster-seniormembers').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: $url_senior_member,
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 53, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#public_roster-members').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: $url_member,
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 36, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#public_roster-probationarymembers').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: $url_probationary_member,
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 70, 53, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#public_roster-reserves').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: $url_reserve,
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 36, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#public_roster-media').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: $url_media,
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 36, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });
});
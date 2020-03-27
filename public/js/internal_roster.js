$(function() {

  var columnsArray = [
    { data: 'name', name: 'name', width: "150px", className: 'text-wrap', render: function (data, type, row) {
      return '<input type="text" class="form-control internal_roster-input_name" data-user-id="'+row['id']+'" value="'+data+'" onchange="internalRoster_changed(this)" required>';
    } },
    { data: 'department_id', name: 'department_id', width: "80px", className: 'text-wrap', render: function (data, type, row) {
      if (data == null) {
        data = '';
      };

      return '<input type="text" class="form-control internal_roster-input_callsign" data-user-id="'+row['id']+'" onchange="internalRoster_changed(this)" value="'+data+'" required>';
    } },
    { data: 'website_id', name: 'website_id', width: "60px", className: 'text-wrap', render: function (data, type, row) {
      return '<input type="text" class="form-control internal_roster-input_websiteid" data-user-id="'+row['id']+'" onchange="internalRoster_changed(this)" value="'+data+'" required>';
    } },
    { data: 'rank', name: 'rank', width: "190px", className: 'text-wrap', render: function (data, type, row) {
      var id = row['id'];
      return internal_roster_rankFieldInput(data, id);
    } },
    { data: 'status', name: 'status', width: "55px", className: 'text-wrap' },
    { data: 'monthly_hours', name: 'monthly_hours', width: "70px", className: 'text-wrap' },
    { data: 'monthly_logs', name: 'monthly_logs', width: "60px", className: 'text-wrap' },
    { data: 'advanced_training', name: 'advanced_training', width: "70px", className: 'text-wrap' },
    { data: 'requirements', name: 'requirements', width: "100px", className: 'text-wrap' },
   ];

  $('#internal_roster-admins').DataTable({
   "autoWidth": false,
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: baseURL + '/public/roster/admins',
   columns: columnsArray,
   "createdRow": function( row, data, dataIndex ) {
     $(row).css('background-color', 'rgba(70, 1, 1, 1.0)');
     $(row).css('color', 'white');
   },
   "bInfo" : false,
  });

  $('#internal_roster-seniorstaff').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: baseURL + '/public/roster/seniorstaff',
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(70, 36, 1, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#internal_roster-staff').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: baseURL + '/public/roster/staff',
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(70, 53, 1, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });


  $('#internal_roster-staffintraining').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: baseURL + '/public/roster/staffintraining',
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 70, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#internal_roster-seniormembers').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: baseURL + '/public/roster/seniormember',
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 53, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#internal_roster-members').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: baseURL + '/public/roster/member',
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 36, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#internal_roster-probationarymembers').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: baseURL + '/public/roster/probationarymember',
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 70, 53, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#internal_roster-reserves').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: baseURL + '/public/roster/reserve',
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 36, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });

  $('#internal_roster-media').DataTable({
   ordering: false,
   serverSide: true,
   searching: false,
   paging: false,
   order: [[ 0  , "desc" ]],
   ajax: baseURL + '/public/roster/media',
   columns: columnsArray,
    "createdRow": function( row, data, dataIndex ) {
       $(row).css('background-color', 'rgba(1, 36, 70, 1.0)');
       $(row).css('color', 'white');
    },
    "bInfo" : false,
  });
});

function internalRoster_changed(data) {
  $(data).addClass('internal_roster-changed');
};

var formSubmitting = false;
var setFormSubmitting = function() { formSubmitting = true; };

window.onload = function() {
    window.addEventListener("beforeunload", function (e) {
        if (formSubmitting) {
            return undefined;
        }

        if ($('.internal_roster-changed').length) {
          var confirmationMessage = 'It looks like you have been editing something. '
                                + 'If you leave before saving, your changes will be lost.';

          (e || window.event).returnValue = confirmationMessage; //Gecko + IE
          return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
        }
    });
};

$('#internal_roster-form').on('submit', function(e) {

  $('.internal_roster-changed').each(function(i, obj) {
    var id = $(obj).data('user-id');

    if($(obj).hasClass("internal_roster-input_name")) {
      var name = $(obj).val();
      $.ajax({
        type: 'POST',
        url: baseURL + '/internal_roster/edit/name/' + id,
        data: {name:name},
      });
    }

    else if($(obj).hasClass("internal_roster-input_websiteid")) {
      var website_id = $(obj).val();
      $.ajax({
        type: 'POST',
        url: baseURL + '/internal_roster/edit/websiteid/' + id,
        data: {website_id:website_id},
      });
    }

    else if($(obj).hasClass("internal_roster-input_callsign")) {
      var callsign = $(obj).val();
      $.ajax({
        type: 'POST',
        url: baseURL + '/internal_roster/edit/callsign/' + id,
        data: {callsign:callsign},
      });
    }

    else if($(obj).hasClass("internal_roster-input_rank")) {
      var rank = $(obj).val();
      $.ajax({
        type: 'POST',
        url: baseURL + '/internal_roster/edit/rank/' + id,
        data: {rank:rank},
      });
    }
  });
});
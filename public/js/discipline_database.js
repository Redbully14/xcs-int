$(function() {
  $('#ajax_disciplinary_actions_table_element').DataTable({
   ordering: true,
   serverSide: true,
   searching: true,
   ajax: baseURL + '/discipline/collection/',
   order: [[ 0  , "desc" ]],
   columns: [
    { data: 'discipline_id', name: 'discipline_id', render: function (data, type, row) {
      return  $discipline_id + data;
    } },
    { data: 'issued_to', name: 'issued_to' },
    { data: 'issued_by', name: 'issued_by' },
    { data: 'discipline_type', name: 'discipline_type', searchable: false },
    { data: 'discipline_date', name: 'discipline_date' },
    { data: 'discipline_details', name: 'discipline_details', searchable: false, render: function (data, type, row) {
      var allowedLength = 35;
      if (data.length >= allowedLength) {
        return data.substr(0, allowedLength)+'...';
      } else {
        return data;
      };
    } },
    { data: 'discipline_status', name: 'discipline_status', searchable: false },
    { data: 'discipline_id', searchable: false, render: function(data, type, row) { return '<button class="btn btn-outline-primary" id="ajax_edit_disciplinary_action-table" value="'+data+'"><i class="mdi mdi-lead-pencil"></i> Edit</button>'; } },
   ],
  });
});
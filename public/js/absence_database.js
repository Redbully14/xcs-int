$(function() {
  if($('#ajax_absence_database_archive-table').length) {
    $('#ajax_absence_database_archive-table').DataTable({
     ordering: true,
     serverSide: true,
     searching: false,
     order: [[ 0  , "desc" ]],
     ajax: baseURL + '/absence/datatable/2',
     columns: [
      { data: 'id', name: 'id', render: function (data, type, row) {
        if(row['admin_approval']) {
          return  $absence_id + 'A-' + data;
        }
        return $absence_id + data;
      } },
      { data: 'name_department_id', name: 'name_department_id' },
      { data: 'website_id', name: 'website_id' },
      { data: 'start_end_date', name: 'start_end_date' },
      { data: 'forum_post', name: 'forum_post', render: function(data, type, row) { return '<a href="'+data+'">FORUM POST</a>'; } },
      { data: 'id', render: function(data, type, row) { return '<button class="btn btn-social-icon btn-primary" id="absence_btn_backtoqueue" title="Send back to queue" value="'+data+'"><i class="mdi mdi-arrow-up-bold-circle-outline"></i></button>'; } }
     ]
    });
  } else {
    $('#ajax_absence_database_AR-table').DataTable({
     ordering: true,
     serverSide: true,
     searching: false,
     order: [[ 0  , "asc" ]],
     ajax: baseURL + '/absence/datatable/0',
     columns: [
      { data: 'id', name: 'id', render: function (data, type, row) {
        if(row['admin_approval']) {
          return '<span class="text-warning">' + $absence_id + 'A-' + data + '</span> <div class="badge badge-pill badge-warning" data-toggle="tooltip" data-custom-class="tooltip-warning" data-container="body" data-placement="right" style="margin-left:2px;" title="The duration of this LOA is over 30 days and requires Admin Approval.">?</div>';
        }
        return $absence_id + data;
      } },
      { data: 'name_department_id', name: 'name_department_id' },
      { data: 'website_id', name: 'website_id' },
      { data: 'start_end_date', name: 'start_end_date', render: function(data, type, row) { 
          if(new Date(row['end_date']) < new Date()) {
            return '<span class="text-danger">'+data+'</span> <div class="badge badge-pill badge-danger" data-toggle="tooltip" data-custom-class="tooltip-danger" data-container="body" data-placement="right" style="margin-left:2px;" title="This LOA is overdue, this means that the end date has been passed.">?</div>';
          } else return data;   
        } 
      },
      { data: 'forum_post', name: 'forum_post', render: function(data, type, row) { return '<a href="'+data+'">FORUM POST</a>'; } },
      { data: 'id', render: function(data, type, row) { return '<button class="btn btn-social-icon btn-success" id="absence_btn_approve" title="Approve" value="'+data+'"><i class="mdi mdi-check"></i></button> <button class="btn btn-social-icon btn-danger" title="Reject" id="absence_btn_block" value="'+data+'"><i class="mdi mdi-minus-circle"></i></button>'; } }
     ],
      drawCallback: function() {
        $('[data-toggle="tooltip"]').tooltip();
      },
      "createdRow": function( row, data, dataIndex ) {
         if(data['admin_approval']) {
          $(row).css('background-color', 'rgba(91, 59, 0, 0.5)');
         } else if(new Date(data['end_date']) < new Date()) {
            $(row).css('background-color', 'rgba(72, 1, 1, 0.5)');
         }
      }
    });

    $('#ajax_absence_database_A-table').DataTable({
     ordering: true,
     serverSide: true,
     searching: false,
     order: [[ 0  , "asc" ]],
     ajax: baseURL + '/absence/datatable/1',
     columns: [
      { data: 'id', name: 'id', render: function (data, type, row) {
        if(row['admin_approval']) {
          return  $absence_id + 'A-' + data;
        }
        return $absence_id + data;
      } },
      { data: 'name_department_id', name: 'name_department_id' },
      { data: 'website_id', name: 'website_id' },
      { data: 'start_end_date', name: 'start_end_date', render: function(data, type, row) { 
          if(new Date(row['end_date']) < new Date()) {
            return '<span class="text-danger">'+data+'</span> <div class="badge badge-pill badge-danger" data-toggle="tooltip" data-custom-class="tooltip-danger" data-container="body" data-placement="right" style="margin-left:2px;" title="This LOA is overdue, this means that the end date has been passed.">?</div>';
          } else return data;   
        } 
      },
      { data: 'forum_post', name: 'forum_post', render: function(data, type, row) { return '<a href="'+data+'">FORUM POST</a>'; } },
      { data: 'id', render: function(data, type, row) { return '<button class="btn btn-social-icon btn-primary" id="absence_btn_backtoqueue" title="Send back to queue" value="'+data+'"><i class="mdi mdi-arrow-up-bold-circle-outline"></i></button> <button class="btn btn-social-icon btn-warning" title="Archive" id="absence_btn_archive" value="'+data+'"><i class="mdi mdi-archive"></i></button>'; } }
     ],
      "createdRow": function( row, data, dataIndex ) {
         if(new Date(data['end_date']) < new Date()) {
            $(row).css('background-color', 'rgba(72, 1, 1, 0.5)');
         }
      },
      drawCallback: function() {
        $('[data-toggle="tooltip"]').tooltip();
      },
    });
  }
});

var awaiting_review_table = $('#ajax_absence_database_AR-table');
var active_table = $('#ajax_absence_database_A-table');
var archived_table = $('#ajax_absence_database_archive-table');

awaiting_review_table.on('click', '#absence_btn_approve', function () {
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
      refreshTables();
    }
  })
});


awaiting_review_table.on('click', '#absence_btn_block', function () {
  var id = $(this).val();
  archivePopup(id);
});

active_table.on('click', '#absence_btn_archive', function () {
  var id = $(this).val();
  archivePopup(id);
});

archived_table.on('click', '#absence_btn_backtoqueue', function () {
  var id = $(this).val();
  queuePopup(id);
});

active_table.on('click', '#absence_btn_backtoqueue', function () {
  var id = $(this).val();
  queuePopup(id);
});

function archiveAbsence(id) {
  $.ajax({
    type: 'POST',
    url: $url_absence_btn_archive + id,
    success: function() {
      var toast_heading = "Leave of Absence Archived!";
      var toast_text = "The Leave of Absence has been archived.";
      var toast_icon = "success";
      var toast_color = "#f96868";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
      refreshTables();
    },
  });
}

function queueAbsence(id) {
  $.ajax({
    type: 'POST',
    url: $url_absence_btn_queue + id,
    success: function() {
      var toast_heading = "Absence Sent to Queue!";
      var toast_text = "The Leave of Absence has been sent back to the reviewal queue for approval.";
      var toast_icon = "success";
      var toast_color = "#f96868";
      globalToast(toast_heading, toast_text, toast_icon, toast_color);
      refreshTables();
    },
  });
}

function refreshTables() {
  if($('#ajax_absence_database_archive-table').length) {
    $('#ajax_absence_database_archive-table').DataTable().ajax.reload();
  }
  else {
    $('#ajax_absence_database_AR-table').DataTable().ajax.reload();
    $('#ajax_absence_database_A-table').DataTable().ajax.reload();
  }
}

function archivePopup(id) {
    let modalNode = $('div[tabindex*="-1"]')
    if (!modalNode) return;

    modalNode.removeAttr('tabindex');
    modalNode.addClass('js-swal-fixed');

    swal({
        title: 'Are you sure?',
        text: "This Leave of Absence will be archived and the member's status will not be changed. Please ensure that the absence has also been properly archived on the forums and the member has been given his tags back on discord.",
        icon: 'warning',
        buttons: {
          confirm: {
            text: "Archive Absence",
            value: true,
            visible: true,
            className: "btn btn-primary",
            closeModal: true
          },
          cancel: {
            text: "Cancel",
            value: null,
            visible: true,
            className: "btn btn-danger",
            closeModal: true,
          }
        }
    }).then(function (isConfirm) {
        let modalNode = $('.js-swal-fixed')
        if (!modalNode) return;

        modalNode.attr('tabindex', '-1');
        modalNode.removeClass('js-swal-fixed');

        swal.close();

        if(isConfirm) {
          archiveAbsence(id);
        }
    })
}

function queuePopup(id) {
    let modalNode = $('div[tabindex*="-1"]')
    if (!modalNode) return;

    modalNode.removeAttr('tabindex');
    modalNode.addClass('js-swal-fixed');

    swal({
        title: 'Are you sure?',
        text: "This Leave of Absence will be sent back to the reviewal queue and the member's LOA status will be revoked on the roster / profile.",
        icon: 'warning',
        buttons: {
          confirm: {
            text: "Send Back to Queue",
            value: true,
            visible: true,
            className: "btn btn-primary",
            closeModal: true
          },
          cancel: {
            text: "Cancel",
            value: null,
            visible: true,
            className: "btn btn-danger",
            closeModal: true,
          }
        }
    }).then(function (isConfirm) {
        let modalNode = $('.js-swal-fixed')
        if (!modalNode) return;

        modalNode.attr('tabindex', '-1');
        modalNode.removeClass('js-swal-fixed');

        swal.close();

        if(isConfirm) {
          queueAbsence(id);
        }
    })
}